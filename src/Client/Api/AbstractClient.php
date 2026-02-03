<?php

declare(strict_types=1);

namespace DummyDemo\Client\Api;

use Closure;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use DummyDemo\Client\Exception\ApiException;
use DummyDemo\Client\Model\ResponseDto;

abstract class AbstractClient
{
    public function __construct(
        protected ?Configuration $config = null,
        protected ?ClientInterface $client = null,
        protected ?Closure $signCallback = null,
        protected ?Closure $signValidatorCallback = null,
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
    }

    public function getConfig(): ?Configuration
    {
        return $this->config;
    }

    public function setConfig(?Configuration $config): void
    {
        $this->config = $config;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function getSignCallback(): ?Closure
    {
        return $this->signCallback;
    }

    public function setSignCallback(?Closure $signCallback): void
    {
        $this->signCallback = $signCallback;
    }

    public function getSignValidatorCallback(): ?Closure
    {
        return $this->signValidatorCallback;
    }

    public function setSignValidatorCallback(?Closure $signValidatorCallback): void
    {
        $this->signValidatorCallback = $signValidatorCallback;
    }

    /**
     * @throws ApiException
     */
    protected function makeRequest(string $url, array $data = []): ?ResponseDto
    {
        $url = sprintf('%s%s', $this->removeTrailingSlash($this->config->getHost()), $this->addLeadingSlash($url));

        $data = array_merge([
            'id' => (string) $this->config->getPartnerId(),
            'uid' => $this->config->getUid(),
            'pwd' => $this->config->getPassword(),
        ], ['data' => $data]);

        $jsonPayload = json_encode($data);

        $encodedSignature = $this->signCallback ? ($this->signCallback)($jsonPayload) : $jsonPayload;

        if ($this->signValidatorCallback) {
            ($this->signCallback)($data, $encodedSignature);
        }

        $options = [
            'headers' => [
                'accept' => 'application/json',
                'Content-Type' => 'application/json; charset=utf-8',
                'Signature' => $encodedSignature,
            ],
            'body' => $jsonPayload,
        ];

        try {
            $response = $this->client->request(
                'POST',
                $url,
                $options,
            );
        } catch (RequestException $e) {
            throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", (int) $e->getCode(), $e->getResponse() ? $e->getResponse()->getHeaders() : null, $e->getResponse() ? (string) $e->getResponse()->getBody() : null);
        } catch (ConnectException|Throwable|Exception $e) {
            throw new ApiException("[{$e->getCode()}] {$e->getMessage()}", (int) $e->getCode(), null, null);
        }

        return $this->prepareResponseDto(self::parseJsonResponseData($response));
    }

    private function prepareResponseDto(array $response): ?ResponseDto
    {
        if (empty($response)) {
            return null;
        }

        return new ResponseDto(
            responseCode: $response['responseCode'],
            responseMessage: $response['remarks'],
            responseData: $response['data'],
        );
    }

    private static function parseJsonResponseData(ResponseInterface $response): array
    {
        $content = $response->getBody()->getContents();

        if (empty($content)) {
            return [];
        }

        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        return $data;
    }

    private function removeTrailingSlash(string $url): string
    {
        if (substr($url, -1) === '/') {
            $url = rtrim($url, '/');
        }

        return $url;
    }

    private function addLeadingSlash(string $path): string
    {
        if (substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }

        return $path;
    }
}
