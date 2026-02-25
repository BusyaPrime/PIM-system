<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class CatalogApiTest extends ApiTestCase
{
    public function testGetCollection(): void
    {
        // Чекаем нашу лютую связку CQRS и API Platform. Работает как тесла, но лучше!
        $response = static::createClient()->request('GET', '/api/products');

        // Ждем голую БД или подсовываем фикстуры, иначе тесты лягут.
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }
}
