import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "./globals.css";
import "@omnipim/ui/styles.css";
import { AuthProvider } from "@/components/providers/AuthProvider";
import { I18nProvider } from "@/components/providers/I18nProvider";

import { ReactQueryProvider } from "@/app/providers/ReactQueryProvider";

const inter = Inter({ subsets: ["latin"] });

export const metadata: Metadata = {
  title: "OmniPIM MAX - Enterprise Backoffice",
  description: "Advanced PIM/MDM System Dashboard",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en" className="dark" suppressHydrationWarning>
      <body className={`${inter.className} min-h-screen bg-background font-sans antialiased overflow-hidden`} suppressHydrationWarning>
        <ReactQueryProvider>
          <I18nProvider>
            <AuthProvider>
              {children}
            </AuthProvider>
          </I18nProvider>
        </ReactQueryProvider>
      </body>
    </html>
  );
}
