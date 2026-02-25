<?php

declare(strict_types=1);

namespace App\Tests\Unit\Catalog;

use App\Catalog\Domain\Entity\Product;
use App\Catalog\Domain\Entity\Family;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testProductInitializationIsCorrect(): void
    {
        $id = 'prod-123';
        $familyMock = $this->createMock(Family::class);

        $product = new Product($id, $familyMock);

        $this->assertEquals($id, $product->getId());
        $this->assertSame($familyMock, $product->getFamily());
        $this->assertInstanceOf(\DateTimeImmutable::class, $product->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $product->getUpdatedAt());
    }
}
