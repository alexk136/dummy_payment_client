<?php

declare(strict_types=1);

namespace DummyDemo\Client\Api;

use DummyDemo\Client\Exception\ApiException;
use DummyDemo\Client\Model\BalanceModel;
use DummyDemo\Client\Model\PrefixModel;
use DummyDemo\Client\Model\ProductModel;
use DummyDemo\Client\Model\ProductModelCollection;
use DummyDemo\Client\Model\ResponseDto;
use DummyDemo\Client\Model\TopUpDataModel;
use DummyDemo\Client\Model\TopUpInquiryDataModel;
use DummyDemo\Client\Model\WalletInquiryDataModel;
use DummyDemo\Client\Model\WalletTopUpDataModel; 

class DummyClient extends AbstractClient
{
    /**
     * @throws ApiException
     */
    public function getBalance(): BalanceModel|ResponseDto
    {
        $responseDto = $this->makeRequest('/balance');

        if (!$responseDto->responseData) {
            return $responseDto;
        }

        return new BalanceModel(
            $responseDto->responseData['credits'],
            $responseDto->responseCode,
            $responseDto->responseMessage,
        );
    }

    /**
     * @throws ApiException
     */
    public function getProductList(): ProductModelCollection|ResponseDto
    {
        $responseDto = $this->makeRequest('/product-list');

        if (!$responseDto->responseData) {
            return $responseDto;
        }

        $products = [];

        foreach ($responseDto->responseData as $productData) {
            $products[] = new ProductModel(
                $productData['provider'],
                $productData['productCode'],
                $productData['description'],
                $productData['denomination'],
                $productData['convenienceFee'],
                $productData['total'],
                $productData['cost'],
                $productData['income'],
                $productData['category'],
                $productData['productType'],
                $productData['endpoint'],
                $productData['inquiryEndpoint'],
                $productData['servers'] ?? null,
            );
        }

        return new ProductModelCollection(
            responseCode: $responseDto->responseCode,
            responseMessage: $responseDto->responseMessage,
            collection: $products,
        );
    }

    /**
     * @throws ApiException
     */
    public function getPrefixList(): ProductModelCollection|ResponseDto
    {
        $responseDto = $this->makeRequest('/prefix-list');

        if (!$responseDto->responseData) {
            return $responseDto;
        }

        $prefixes = [];

        foreach ($responseDto->responseData as $prefixData) {
            $prefixes[] = new PrefixModel(
                $prefixData['provider'],
                $prefixData['prefix'],
            );
        }

        return new ProductModelCollection(
            responseCode: $responseDto->responseCode,
            responseMessage: $responseDto->responseMessage,
            collection: $prefixes,
        );
    }

    /**
     * @throws ApiException
     */
    public function sendTopUpRequest(string $productCode, string $mobileNo, string $agentRefNo): TopUpDataModel|ResponseDto
    {
        $responseDto = $this->makeRequest('/topup-request', [
            'productCode' => $productCode,
            'mobileNo' => $mobileNo,
            'agentRefNo' => $agentRefNo,
        ]);

        if (!$responseDto->responseData) {
            return $responseDto;
        }

        $data = $responseDto->responseData;

        return new TopUpDataModel(
            $data['transactionNo'],
            $data['referenceNo'],
            $data['mobileNo'],
            $data['productCode'],
            $data['denomination'],
            $data['convenienceFee'],
            $data['total'],
            $data['cost'],
            $data['income'],
            $responseDto->responseCode,
            $responseDto->responseMessage,
        );
    }

    /**
     * @throws ApiException
     */
    public function sendTopUpInquiry(string $agentRefNo): TopUpInquiryDataModel|ResponseDto
    {
        $responseDto = $this->makeRequest('/topup-inquiry', [
            'agentRefNo' => $agentRefNo,
        ]);

        if (!$responseDto->responseData) {
            return $responseDto;
        }

        $data = $responseDto->responseData;

        return new TopUpInquiryDataModel(
            $data['transactionNo'],
            $data['referenceNo'],
            $data['mobileNo'],
            $data['productCode'],
            $data['denomination'],
            $data['convenienceFee'],
            $data['total'],
            $data['cost'],
            $data['income'],
            $responseDto->responseCode,
            $responseDto->responseMessage,
        );
    }

                            /**
     * @throws ApiException
     */
    public function sendWalletTopUpRequest(
        string $productCode,
        float $amount,
        string $mobileNo,
        string $identifier,
        string $agentRefNo,
    ): WalletTopUpDataModel|ResponseDto {
        $responseDto = $this->makeRequest('/wallet-request', [
            'productCode' => $productCode,
            'amount' => $amount,
            'mobileNo' => $mobileNo,
            'identifier' => $identifier,
            'agentRefNo' => $agentRefNo,
        ]);

        if (!$responseDto->responseData) {
            return $responseDto;
        }

        $data = $responseDto->responseData;

        return new WalletTopUpDataModel(
            $data['transactionNo'],
            $data['referenceNo'],
            $data['mobileNo'],
            $data['identifier'],
            $data['productCode'],
            $data['denomination'],
            $data['convenienceFee'],
            $data['total'],
            $data['cost'],
            $data['income'],
            $responseDto->responseCode,
            $responseDto->responseMessage,
        );
    }

    /**
     * @throws ApiException
     */
    public function inquireWallet(string $agentRefNo): WalletInquiryDataModel|ResponseDto
    {
        $responseDto = $this->makeRequest('/wallet-inquiry', [
            'agentRefNo' => $agentRefNo,
        ]);

        if (!$responseDto->responseData) {
            return $responseDto;
        }

        $data = $responseDto->responseData;

        return new WalletInquiryDataModel(
            $data['transactionNo'],
            $data['referenceNo'],
            $data['mobileNo'],
            $data['identifier'],
            $data['productCode'],
            $data['denomination'],
            $data['convenienceFee'],
            $data['total'],
            $data['cost'],
            $data['income'],
            $responseDto->responseCode,
            $responseDto->responseMessage,
        );
    }

}
