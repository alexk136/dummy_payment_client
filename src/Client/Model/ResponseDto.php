<?php

declare(strict_types=1);

namespace DummyDemo\Client\Model;

final class ResponseDto
{
    public function __construct(
        public int $responseCode,
        public string $responseMessage,
        public ?array $responseData,
    ) {
    }
}
