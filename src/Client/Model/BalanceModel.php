<?php

declare(strict_types=1);

namespace DummyDemo\Client\Model;

final readonly class BalanceModel
{
    public function __construct(
        public float $credits,
        public int $responseCode,
        public string $responseMessage,
    ) {
    }
}
