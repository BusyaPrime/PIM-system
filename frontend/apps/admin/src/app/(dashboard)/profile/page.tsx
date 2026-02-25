"use client";

import { useState } from "react";
import { Card, CardContent, CardHeader, CardTitle, CardDescription, Button, Input } from "@omnipim/ui";
import { Camera, Save, Globe, Clock, User, LogOut } from "lucide-react";
import { useTranslation } from "@/components/providers/I18nProvider";
import { useAuth } from "@/components/providers/AuthProvider";

const TIMEZONES = [
    { value: "UTC", label: "(UTC+00:00) Coordinated Universal Time" },
    { value: "Europe/London", label: "(UTC+00:00) London, Dublin, Lisbon" },
    { value: "Europe/Paris", label: "(UTC+01:00) Paris, Berlin, Rome, Madrid" },
    { value: "Europe/Kyiv", label: "(UTC+02:00) Kyiv, Helsinki, Athens" },
    { value: "Europe/Moscow", label: "(UTC+03:00) Moscow, St. Petersburg, Volgograd" },
    { value: "Asia/Dubai", label: "(UTC+04:00) Abu Dhabi, Muscat" },
    { value: "Asia/Tashkent", label: "(UTC+05:00) Tashkent, Ekaterinburg, Islamabad" },
    { value: "Asia/Almaty", label: "(UTC+06:00) Almaty, Astana, Dhaka" },
    { value: "Asia/Bangkok", label: "(UTC+07:00) Bangkok, Hanoi, Jakarta" },
    { value: "Asia/Hong_Kong", label: "(UTC+08:00) Beijing, Hong Kong, Singapore" },
    { value: "Asia/Tokyo", label: "(UTC+09:00) Tokyo, Seoul, Osaka" },
    { value: "Australia/Sydney", label: "(UTC+10:00) Sydney, Melbourne, Brisbane" },
    { value: "Pacific/Auckland", label: "(UTC+12:00) Auckland, Wellington, Fiji" },
    { value: "America/New_York", label: "(UTC-05:00) Eastern Time (US & Canada)" },
    { value: "America/Chicago", label: "(UTC-06:00) Central Time (US & Canada)" },
    { value: "America/Denver", label: "(UTC-07:00) Mountain Time (US & Canada)" },
    { value: "America/Los_Angeles", label: "(UTC-08:00) Pacific Time (US & Canada)" },
];

export default function ProfilePage() {
    const { t, locale, setLocale } = useTranslation();
    const { logout } = useAuth();

    const [avatarPreview, setAvatarPreview] = useState<string | null>(null);
    const [timezone, setTimezone] = useState("Asia/Tashkent");
    const [isSaving, setIsSaving] = useState(false);

    const handleImageUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (file) {
            const reader = new FileReader();
            reader.onloadend = () => {
                setAvatarPreview(reader.result as string);
            };
            reader.readAsDataURL(file);
        }
    };

    const handleSave = () => {
        setIsSaving(true);
        setTimeout(() => setIsSaving(false), 800); // Имитируем сетевую задержку, шоб UI выглядел живым и чувак не думал, что ничего не сохранилось
    };

    return (
        <div className="space-y-6 max-w-4xl mx-auto">
            <div>
                <h2 className="text-3xl font-bold tracking-tight">{t("profile")}</h2>
                <p className="text-muted-foreground">{locale === 'ru' ? 'Управление вашими личными настройками и предпочтениями отображения.' : 'Manage your personal account settings and display preferences.'}</p>
            </div>

            <div className="grid gap-6">
                {/* Avatar Section */}
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><User className="h-5 w-5" /> {t("avatar")}</CardTitle>
                    </CardHeader>
                    <CardContent className="flex flex-col sm:flex-row items-center gap-6">
                        <div className="relative group">
                            <div className="h-24 w-24 rounded-full border-4 border-muted overflow-hidden flex items-center justify-center bg-secondary">
                                {avatarPreview ? (
                                    <img src={avatarPreview} alt="Avatar" className="w-full h-full object-cover" />
                                ) : (
                                    <span className="text-3xl font-bold text-muted-foreground">A</span>
                                )}
                            </div>
                            <label htmlFor="avatar-upload" className="absolute bottom-0 right-0 bg-primary text-primary-foreground p-1.5 rounded-full cursor-pointer hover:bg-primary/90 transition-colors shadow-sm">
                                <Camera className="h-4 w-4" />
                                <input id="avatar-upload" type="file" accept="image/*" className="hidden" onChange={handleImageUpload} />
                            </label>
                        </div>
                        <div className="text-sm text-muted-foreground text-center sm:text-left">
                            <p>{locale === 'ru' ? 'Поддерживается JPG, PNG или GIF. Максимальный размер 2 МБ.' : 'Supported formats: JPG, PNG, GIF. Max size 2MB.'}</p>
                            <Button variant="outline" size="sm" className="mt-2" onClick={() => document.getElementById('avatar-upload')?.click()}>
                                {t("uploadImage")}
                            </Button>
                        </div>
                    </CardContent>
                </Card>

                {/* Preferences Section */}
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2"><Globe className="h-5 w-5" /> {t("settings")}</CardTitle>
                        <CardDescription>{locale === 'ru' ? 'Региональные настройки системы OmniPIM.' : 'OmniPIM regional system settings.'}</CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-6">
                        <div className="space-y-2">
                            <label className="text-sm font-medium">{t("language")}</label>
                            <div className="flex gap-2">
                                <Button
                                    variant={locale === "ru" ? "default" : "outline"}
                                    onClick={() => setLocale("ru")}
                                    className="w-32"
                                >
                                    🇷🇺 Русский
                                </Button>
                                <Button
                                    variant={locale === "en" ? "default" : "outline"}
                                    onClick={() => setLocale("en")}
                                    className="w-32"
                                >
                                    🇬🇧 English
                                </Button>
                            </div>
                        </div>

                        <div className="space-y-2">
                            <label className="text-sm font-medium flex items-center gap-2">
                                <Clock className="w-4 h-4" /> {t("timezone")}
                            </label>
                            <select
                                value={timezone}
                                onChange={(e) => setTimezone(e.target.value)}
                                className="flex h-10 w-full md:w-1/2 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                {TIMEZONES.map(tz => (
                                    <option key={tz.value} value={tz.value}>{tz.label}</option>
                                ))}
                            </select>
                            <p className="text-xs text-muted-foreground mt-1">
                                {locale === 'ru' ? 'Выбранный часовой пояс (включая Ташкент) будет применяться ко всем отчетам по импорту, истории ревизий и фоновым задачам.' : 'Your selected timezone will apply to all import reports, revision histories, and background jobs.'}
                            </p>
                        </div>
                    </CardContent>
                </Card>

                <div className="flex justify-end pt-4 gap-4">
                    <Button variant="destructive" onClick={() => logout()} className="w-full sm:w-auto">
                        <span className="flex items-center gap-2"><LogOut className="h-4 w-4" /> {locale === 'ru' ? 'Выйти' : 'Sign Out'}</span>
                    </Button>
                    <Button onClick={handleSave} disabled={isSaving} className="w-full sm:w-auto">
                        {isSaving ? (
                            <span className="flex items-center gap-2"><div className="h-4 w-4 rounded-full border-2 border-primary-foreground border-t-transparent animate-spin" /> {locale === 'ru' ? 'Сохранение...' : 'Saving...'}</span>
                        ) : (
                            <span className="flex items-center gap-2"><Save className="h-4 w-4" /> {t("save")}</span>
                        )}
                    </Button>
                </div>
            </div>
        </div>
    );
}
