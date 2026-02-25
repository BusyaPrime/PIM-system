<?php

declare(strict_types=1);

namespace App\Enrichment\Domain\Service;

use App\Catalog\Domain\Entity\Product;

interface CompletenessCalculatorInterface
{
    /**
     * Считаем процент заполненности для продукта в заданном канале и локали (Akeneo-style комплитность).
     * Возвращает float от 0.0 до 100.0 (процент готовности продукта)
     */
    public function calculate(Product $product, ?string $channel = null, ?string $locale = null): float;
}
