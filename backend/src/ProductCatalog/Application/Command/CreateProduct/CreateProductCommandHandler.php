<?php

declare(strict_types=1);

namespace App\ProductCatalog\Application\Command\CreateProduct;

use App\ProductCatalog\Domain\Entity\Product;
use App\ProductCatalog\Domain\Repository\ProductRepositoryInterface;
use App\ProductCatalog\Domain\ValueObject\ProductId;
use App\ProductCatalog\Domain\ValueObject\ProductSku;
use App\Shared\Application\Command\CommandHandlerInterface;

final class CreateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        // В нормальном боевом энтерпрайзе мы бы сейчас инжектнули EventBus и стрельнули ивентом в шину
    ) {
    }

    public function __invoke(CreateProductCommand $command): void
    {
        $product = Product::create(
            new ProductId($command->id),
            new ProductSku($command->sku),
            $command->name
        );

        $this->productRepository->save($product);

        // $events = $product->pullDomainEvents();
        // foreach ($events as $event) { $this->eventBus->publish($event); } // Пуляем ивенты, работает как тесла, но лучше!
    }
}
