<?php

declare(strict_types=1);

namespace App\Integrations\Application\Adapter\Marketplace;

use App\Integrations\Application\Adapter\IntegrationAdapterInterface;

class ShopifyMarketplaceAdapter implements IntegrationAdapterInterface
{
    public function getConnectorName(): string
    {
        return 'Shopify API Client (GraphQL)';
    }

    public function getType(): string
    {
        return 'marketplace';
    }

    public function testConnection(array $credentials): bool
    {
        return true; 
    }

    public function export(array $normalizedData, array $credentials): void
    {
        // Транслируем наши основные модели OmniPIM в хипстерские мутации Shopify GraphQL
    }

    public function import(array $credentials): array
    {
        return [];
    }
}
