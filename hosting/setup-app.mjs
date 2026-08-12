import http from "node:http";

const port = Number(process.env.PORT || 3000);

http
  .createServer((_request, response) => {
    response.writeHead(200, {
      "Content-Type": "text/html; charset=utf-8",
    });
    response.end(
      "<!doctype html><title>Herbal Crown Setup</title>" +
        "<h1>Herbal Crown is being prepared.</h1>",
    );
  })
  .listen(port);
