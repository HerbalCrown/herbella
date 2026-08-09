import type { Metadata } from "next";
import "./globals.css";

export const metadata: Metadata = {
  title: "Herbella — Botanical Luxury Hair Oil",
  description: "Discover Herbella by Herbal Crown: a luxury hair oil ritual blending 20+ botanicals for stronger-looking, radiant hair.",
  icons: { icon: "/favicon.svg" },
  openGraph: {
    title: "Herbella — Botanical Luxury Hair Oil",
    description: "Rooted in nature. Crowned in confidence.",
    images: [{ url: "/og.png", width: 1200, height: 630, alt: "Herbella Botanical Luxury Hair Oil" }],
  },
  twitter: { card: "summary_large_image", images: ["/og.png"] },
};

export default function RootLayout({ children }: Readonly<{ children: React.ReactNode }>) {
  return <html lang="en"><body>{children}</body></html>;
}
