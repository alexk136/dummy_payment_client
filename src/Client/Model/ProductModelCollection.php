<?php

declare(strict_types=1);

namespace DummyDemo\Client\Model;

final readonly class ProductModelCollection
{
    public function __construct(
        public int $responseCode,
        public string $responseMessage,
        public array $collection = [],
    ) {
    }
}
