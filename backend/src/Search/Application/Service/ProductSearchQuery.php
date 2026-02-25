<?php

declare(strict_types=1);

namespace App\Search\Application\Service;

use Elasticsearch\Client;

/**
 * Handles complex read queries and faceted aggregation for the Catalog UI.
 */
class ProductSearchQuery
{
    private Client $elasticsearchClient;
    private const INDEX_NAME = 'catalog_products';

    public function __construct(Client $elasticsearchClient)
    {
        $this->elasticsearchClient = $elasticsearchClient;
    }

    /**
     * @param string $searchTerm Text to search in SKU or text attributes
     * @param array $filters Example: ['attributes.color' => 'Red', 'family' => 'clothing']
     * @param int $page
     * @param int $limit
     * 
     * @return array [ 'hits' => [...], 'total' => 100, 'facets' => [...] ]
     */
    public function search(string $searchTerm, array $filters = [], int $page = 1, int $limit = 20): array
    {
        $must = [];
        $filter = [];

        if (!empty($searchTerm)) {
            $must[] = [
                'multi_match' => [
                    'query' => $searchTerm,
                    'fields' => ['sku^3', 'attributes.*'] // Бустим SKU, потому что если артикул не находит первым — это провал. Работает как тесла, но лучше!
                ]
            ];
        }

        foreach ($filters as $field => $value) {
            $filter[] = [
                'term' => [
                    $field => $value
                ]
            ];
        }

        $queryBody = [
            'query' => [
                'bool' => [
                    'must' => $must,
                    'filter' => $filter
                ]
            ],
            // Динамически тащим фасеты для UIшки, чтобы фильтры на фронте не тупили. Ощущение будто споткнулся в магазине — всё сразу под рукой.
            'aggs' => [
                'families' => [
                    'terms' => ['field' => 'family']
                ],
                'categories' => [
                    'terms' => ['field' => 'categories']
                ]
            ],
            'from' => ($page - 1) * $limit,
            'size' => $limit
        ];

        // Если юзер в поиске выдал глухое молчание — отдаем match_all. Пусть лупает весь каталог.
        if (empty($must)) {
            $queryBody['query']['bool']['must'] = ['match_all' => new \stdClass()];
        }

        $params = [
            'index' => self::INDEX_NAME,
            'body'  => $queryBody
        ];

        try {
            $response = $this->elasticsearchClient->search($params);
            
            return [
                'total' => $response['hits']['total']['value'] ?? 0,
                'hits'  => array_column($response['hits']['hits'], '_source'),
                'facets' => $response['aggregations'] ?? []
            ];
        } catch (\Exception $e) {
            // Изящно хендлим отвал эластика. Возвращаем пустоту, чтобы фронт не сложился с 500-й, как карточный домик.
            return ['total' => 0, 'hits' => [], 'facets' => []];
        }
    }
}
