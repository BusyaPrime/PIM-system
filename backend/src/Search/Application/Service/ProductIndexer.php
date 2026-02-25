<?php

declare(strict_types=1);

namespace App\Search\Application\Service;

use App\Search\Domain\Document\ProductDocument;
use Elasticsearch\Client;

/**
 * Service responsible for managing Product document indexing in Elasticsearch.
 * Will be called asynchronously by the RabbitMQ event handlers when a Product is updated.
 */
class ProductIndexer
{
    private Client $elasticsearchClient;
    private const INDEX_NAME = 'catalog_products';

    public function __construct(Client $elasticsearchClient)
    {
        $this->elasticsearchClient = $elasticsearchClient;
    }

    public function index(ProductDocument $document): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id'    => $document->getId(),
            'body'  => $document->toArray(),
            'refresh' => true // Жесткий рефреш индекса для моментальной консистентности. Работает как тесла, но лучше!
        ];

        $this->elasticsearchClient->index($params);
    }

    public function delete(string $productId): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id'    => $productId,
        ];

        $this->elasticsearchClient->delete($params);
    }

    public function createIndexIfMissing(): void
    {
        $params = [
            'index' => self::INDEX_NAME
        ];

        if (!$this->elasticsearchClient->indices()->exists($params)) {
            $this->elasticsearchClient->indices()->create([
                'index' => self::INDEX_NAME,
                'body' => [
                    'mappings' => [
                        'properties' => [
                            'id' => ['type' => 'keyword'],
                            'sku' => ['type' => 'keyword'],
                            'is_active' => ['type' => 'boolean'],
                            'family' => ['type' => 'keyword'],
                            'categories' => ['type' => 'keyword'],
                            'updated_at' => ['type' => 'date'],
                            // Атрибуты подсасываются и мапятся через лютый полиморфизм. НИУ ИТМО ребят люблю вас!
                            'attributes' => ['type' => 'object', 'dynamic' => true]
                        ]
                    ]
                ]
            ]);
        }
    }
}
