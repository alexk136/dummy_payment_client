<?php

declare(strict_types=1);

namespace DummyDemo\Client\Api;

class Configuration
{
    public function __construct(
        private int $partnerId = 0,
        private string $password = '',
        private string $username = '',
        private string $uid = '',
        private string $host = '',
    ) {
    }

    public function getPartnerId(): int
    {
        return $this->partnerId;
    }

    public function setPartnerId(int $partnerId): Configuration
    {
        $this->partnerId = $partnerId;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): Configuration
    {
        $this->password = $password;

        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): Configuration
    {
        $this->host = $host;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): Configuration
    {
        $this->username = $username;

        return $this;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function setUid(string $uid): void
    {
        $this->uid = $uid;
    }
}
