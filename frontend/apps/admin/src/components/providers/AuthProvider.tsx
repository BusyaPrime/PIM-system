"use client";

import { createContext, useContext, useEffect, useState } from "react";
import { useRouter, usePathname } from "next/navigation";

interface AuthContextType {
    isAuthenticated: boolean;
    token: string | null;
    user: any | null; // Сюда падает жирный JSON с бэка после /api/me
    login: (token: string) => void;
    logout: () => void;
}

const AuthContext = createContext<AuthContextType | null>(null);

export function AuthProvider({ children }: { children: React.ReactNode }) {
    const [user, setUser] = useState<any | null>(null);
    const [isAuthenticated, setIsAuthenticated] = useState<boolean>(false);
    const [isInitializing, setIsInitializing] = useState(true);
    const router = useRouter();
    const pathname = usePathname();

    useEffect(() => {
        const verifySession = async () => {
            try {
                // Стучимся в бэкач для проверки HttpOnly куки BEARER. Секьюрность как в Форт-Ноксе.
                const res = await fetch("http://localhost:8000/api/me", {
                    credentials: "include", // Кровь из носа надо, чтобы браузер прицепил куки
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (res.ok) {
                    const data = await res.json();
                    setUser(data);
                    setIsAuthenticated(true);
                } else {
                    setIsAuthenticated(false);
                    setUser(null);
                }
            } catch (e) {
                console.error("Session verification failed", e);
                setIsAuthenticated(false);
                setUser(null);
            } finally {
                setIsInitializing(false);
            }
        };

        verifySession();
    }, []);

    useEffect(() => {
        if (!isInitializing && !isAuthenticated && pathname !== "/login") {
            router.push("/login");
        }
    }, [isAuthenticated, isInitializing, pathname, router]);

    const login = (newToken: string) => {
        // Костыль-заглушка для Email/Password входа (в OAuth потоке мы сюда не ходим)
        setIsAuthenticated(true);
        router.push("/");
    };

    const logout = async () => {
        try {
            // Дергаем бекенд, чтобы он прибил куку намертво
            await fetch("http://localhost:8000/auth/logout", {
                method: "POST",
                credentials: "include"
            });
        } catch (e) {
            console.error(e);
        }
        setUser(null);
        setIsAuthenticated(false);
        router.push("/login");
    };

    if (isInitializing) {
        return <div className="flex h-screen w-full items-center justify-center">Loading PIM...</div>;
    }

    return (
        <AuthContext.Provider value={{ isAuthenticated, user, token: "httponly", login, logout }}>
            {children}
        </AuthContext.Provider>
    );
}

export const useAuth = () => {
    const context = useContext(AuthContext);
    if (!context) throw new Error("useAuth must be used within an AuthProvider");
    return context;
};
