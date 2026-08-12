import { createReadStream, existsSync, statSync } from "node:fs";
import { createServer } from "node:http";
import { extname, resolve, sep } from "node:path";
import { Readable } from "node:stream";
import handler from "./index.js";

const port = Number(process.env.PORT || 3000);
const host = process.env.HOST || "0.0.0.0";
const clientRoot = resolve(import.meta.dirname, "..", "client");

const contentTypes = {
  ".css": "text/css; charset=utf-8",
  ".gif": "image/gif",
  ".html": "text/html; charset=utf-8",
  ".ico": "image/x-icon",
  ".jpeg": "image/jpeg",
  ".jpg": "image/jpeg",
  ".js": "text/javascript; charset=utf-8",
  ".json": "application/json; charset=utf-8",
  ".png": "image/png",
  ".svg": "image/svg+xml",
  ".webp": "image/webp",
  ".woff": "font/woff",
  ".woff2": "font/woff2",
};

function staticFile(pathname) {
  let decoded;
  try {
    decoded = decodeURIComponent(pathname);
  } catch {
    return null;
  }

  const candidate = resolve(clientRoot, `.${decoded}`);
  if (candidate !== clientRoot && !candidate.startsWith(clientRoot + sep)) {
    return null;
  }

  if (!existsSync(candidate) || !statSync(candidate).isFile()) return null;
  return candidate;
}

function sendStatic(req, res, pathname) {
  if (req.method !== "GET" && req.method !== "HEAD") return false;
  const file = staticFile(pathname);
  if (!file) return false;

  const stats = statSync(file);
  const extension = extname(file).toLowerCase();
  res.statusCode = 200;
  res.setHeader("content-type", contentTypes[extension] || "application/octet-stream");
  res.setHeader("content-length", stats.size);
  res.setHeader(
    "cache-control",
    pathname.startsWith("/_next/static/")
      ? "public, max-age=31536000, immutable"
      : "public, max-age=3600",
  );

  if (req.method === "HEAD") {
    res.end();
  } else {
    createReadStream(file).pipe(res);
  }
  return true;
}

function requestUrl(req) {
  const protocol = req.headers["x-forwarded-proto"] || "https";
  const forwardedHost = req.headers["x-forwarded-host"];
  const requestHost = Array.isArray(forwardedHost)
    ? forwardedHost[0]
    : forwardedHost || req.headers.host || "localhost";
  return `${protocol}://${requestHost}${req.url || "/"}`;
}

function toWebRequest(req) {
  const method = req.method || "GET";
  const init = { method, headers: req.headers };

  if (method !== "GET" && method !== "HEAD") {
    init.body = Readable.toWeb(req);
    init.duplex = "half";
  }

  return new Request(requestUrl(req), init);
}

async function sendWebResponse(response, res) {
  res.statusCode = response.status;
  for (const [name, value] of response.headers) {
    if (name.toLowerCase() !== "set-cookie") res.setHeader(name, value);
  }

  const cookies = response.headers.getSetCookie?.();
  if (cookies?.length) res.setHeader("set-cookie", cookies);

  res.setHeader("x-content-type-options", "nosniff");
  res.setHeader("referrer-policy", "strict-origin-when-cross-origin");

  if (!response.body) {
    res.end();
    return;
  }

  Readable.fromWeb(response.body).pipe(res);
}

const server = createServer(async (req, res) => {
  try {
    const url = new URL(req.url || "/", "http://localhost");
    if (sendStatic(req, res, url.pathname)) return;

    const pending = [];
    const context = {
      waitUntil(promise) {
        pending.push(Promise.resolve(promise));
      },
      passThroughOnException() {},
    };

    const response = await handler(toWebRequest(req), {}, context);
    await sendWebResponse(response, res);
    void Promise.allSettled(pending);
  } catch (error) {
    console.error("Request failed:", error);
    if (!res.headersSent) {
      res.statusCode = 500;
      res.setHeader("content-type", "text/plain; charset=utf-8");
    }
    res.end("Internal Server Error");
  }
});

server.listen(port, host, () => {
  console.log(`Herbal Crown is listening on ${host}:${port}`);
});
