<?php

declare(strict_types=1);

namespace DummyDemo\Client\Model;

final readonly class WalletTopUpDataModel
{
    public function __construct(
        public string $transactionNo,
        public string $referenceNo,
        public string $mobileNo,
        public string $identifier,
        public string $productCode,
        public float $denomination,
        public float $convenienceFee,
        public float $total,
        public float $cost,
        public float $income,
        public int $responseCode,
        public string $responseMessage,
    ) {
    }
}
