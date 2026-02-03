<?php

declare(strict_types=1);

namespace DummyDemo\Client\Model;

final readonly class ProductModel
{
    public function __construct(
        public string $provider,
        public string $productCode,
        public string $description,
        public float $denomination,
        public float $convenienceFee,
        public float $total,
        public float $cost,
        public float $income,
        public string $category,
        public string $productType,
        public string $endpoint,
        public string $inquiryEndpoint,
        public ?array $servers = null,
    ) {
    }
}
