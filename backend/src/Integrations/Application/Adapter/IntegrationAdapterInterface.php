<?php

declare(strict_types=1);

namespace App\Integrations\Application\Adapter;

/**
 * Стандартная точка входа для нативного экспорта/импорта данных в сторонние каналы (экстерналы).
 */
interface IntegrationAdapterInterface
{
    public function getConnectorName(): string;
    
    public function getType(): string; // Что за дичь мы интегрируем: 'marketplace', 'erp', 'cms' и т.д.

    public function testConnection(array $credentials): bool;

    /**
     * Берем наш красивый нормализованный пейлоад, мапим в то уродство, которое ждет внешний API, и пушим.
     */
    public function export(array $normalizedData, array $credentials): void;
    
    /**
     * Дергаем внешнюю ручку и мапим их дикий ответ в наш уютный OmniPIM-формат.
     */
    public function import(array $credentials): array;
}
