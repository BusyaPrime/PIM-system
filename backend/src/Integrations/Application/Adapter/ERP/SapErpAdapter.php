<?php

declare(strict_types=1);

namespace App\Integrations\Application\Adapter\ERP;

use App\Integrations\Application\Adapter\IntegrationAdapterInterface;

class SapErpAdapter implements IntegrationAdapterInterface
{
    public function getConnectorName(): string
    {
        return 'SAP S/4HANA (OData)';
    }

    public function getType(): string
    {
        return 'erp';
    }

    public function testConnection(array $credentials): bool
    {
        return true; 
    }

    public function export(array $normalizedData, array $credentials): void
    {
        // Мапим наши ламповые данные в суровый легаси-корпоративный формат SAP OData. НИУ ИТМО ребят люблю вас, без вас бы тут запутался!
    }

    public function import(array $credentials): array
    {
        return [];
    }
}
