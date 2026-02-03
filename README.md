# Dummy Demo Client 🔧

**Short disclaimer:** This repository contains a sample implementation of a payment client provided strictly for demonstration and educational purposes. It is **not** production-ready and must **not** be used to process real transactions.

Use this code to explore integration approaches, tests, and example workflows only. For production use, review security, compliance, and integration requirements carefully and implement robust error handling, validations, and safeguards.

---

## Symfony Bundle

This package now provides a standard Symfony bundle to easily integrate the client into Symfony applications.

### Installation

Add the package to your project (example):

```bash
composer require dummy-demo/client
```

### Registration (if needed)

Register the bundle in `config/bundles.php` (if your project does not use Flex):

```php
return [
    // ...
    DummyDemo\ClientBundle\ClientBundle::class => ['all' => true],
];
```

If you use Symfony Flex this bundle should be registered automatically.

### Configuration

Create `config/packages/dummy_demo_client.yaml` with the configuration options:

```yaml
dummy_demo_client:
  partner_id: 123
  username: 'your-username'
  password: 'your-password'
  uid: 'your-uid'
  host: 'https://api.example.com'
  # http_client_service: 'http_client' # optional: override http client service id
```

Services are provided and autowired. The `DummyDemo\Client\Api\DummyClient` service is public and can be autowired or fetched from the container.

