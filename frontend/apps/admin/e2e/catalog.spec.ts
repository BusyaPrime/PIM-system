import { test, expect } from '@playwright/test';

test.describe('Catalog Management', () => {
    test('should navigate to product editor and view completeness score', async ({ page }) => {
        // Залетаем с ноги на тестовую урлу, которую мы собрали в Фазе 7
        await page.goto('/catalog/editor');

        // Чекаем тайтл, чтоб тест не сложился как карточный домик в самом начале
        await expect(page.locator('h2')).toContainText('Product Editor');

        // Ищем фичу оценки комплитности профиля как в этих ваших Akeneo. Работает как тесла!
        await expect(page.locator('text=Completeness Score').first()).toBeVisible();

        // Чекаем, что кнопка "Сохранить главные атрибуты" вообще рендерится, а не отвалилась по дороге
        await expect(page.locator('button:has-text("Save Attributes")')).toBeVisible();
    });
});
