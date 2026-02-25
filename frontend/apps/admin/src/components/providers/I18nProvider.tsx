"use client";

import React, { createContext, useContext, useState, useEffect } from "react";

type Locale = "en" | "ru";

interface Translations {
    [key: string]: {
        [key: string]: string;
    };
}

const translations: Translations = {
    en: {
        dashboard: "Dashboard",
        catalog: "Catalog",
        taxonomy: "Taxonomy",
        quality: "Data Quality",
        jobs: "Jobs & Queues",
        revisions: "Audit & Revisions",
        workflows: "Workflows",
        users: "Access & Users",
        settings: "Settings",
        profile: "My Profile",
        save: "Save Changes",
        timezone: "Timezone",
        language: "Language",
        avatar: "Profile Picture",
        theme: "Theme",
        uploadImage: "Upload Image",
        search: "Search...",
        logout: "Log out"
    },
    ru: {
        dashboard: "Главная Панель",
        catalog: "Каталог Товаров",
        taxonomy: "Дерево Категорий",
        quality: "Качество Данных",
        jobs: "Фоновые Задачи",
        revisions: "История Изменений",
        workflows: "Бизнес-Процессы",
        users: "Пользователи и Роли",
        settings: "Настройки Системы",
        profile: "Мой Профиль",
        save: "Сохранить Изменения",
        timezone: "Часовой Пояс",
        language: "Язык Интерфейса",
        avatar: "Фото Профиля",
        theme: "Тема Оформления",
        uploadImage: "Загрузить Фото",
        search: "Поиск...",
        logout: "Выйти"
    }
};

interface I18nContextType {
    locale: Locale;
    setLocale: (l: Locale) => void;
    t: (key: string) => string;
}

const I18nContext = createContext<I18nContextType | undefined>(undefined);

export function I18nProvider({ children }: { children: React.ReactNode }) {
    const [locale, setLocale] = useState<Locale>("ru"); // Жестко дефолтим на русский язык (RU), без базара

    useEffect(() => {
        const saved = localStorage.getItem("omnipim-locale");
        if (saved === "en" || saved === "ru") {
            setLocale(saved);
        }
    }, []);

    const changeLocale = (newLocale: Locale) => {
        setLocale(newLocale);
        localStorage.setItem("omnipim-locale", newLocale);
    };

    const t = (key: string) => {
        return translations[locale][key] || key;
    };

    return (
        <I18nContext.Provider value={{ locale, setLocale: changeLocale, t }}>
            {children}
        </I18nContext.Provider>
    );
}

export function useTranslation() {
    const context = useContext(I18nContext);
    if (!context) throw new Error("useTranslation must be used within I18nProvider");
    return context;
}
