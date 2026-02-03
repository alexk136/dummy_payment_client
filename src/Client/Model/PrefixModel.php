<?php

declare(strict_types=1);

namespace DummyDemo\Client\Model;

final readonly class PrefixModel
{
    public function __construct(
        public string $provider,
        public string $prefix,
    ) {
    }
}
