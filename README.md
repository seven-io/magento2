<p align="center">
  <img src="https://www.seven.io/wp-content/uploads/Logo.svg" width="250" alt="seven logo" />
</p>

<h1 align="center">seven SMS for Magento 2</h1>

<p align="center">
  Send transactional SMS for customer registration, order submission and shipment events directly from <a href="https://magento.com/">Magento 2</a>.
</p>

<p align="center">
  <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-teal.svg" alt="MIT License" /></a>
  <img src="https://img.shields.io/badge/Magento-2.3%2B-orange" alt="Magento 2.3+" />
  <img src="https://img.shields.io/badge/PHP-7.3%2B-purple" alt="PHP 7.3+" />
  <a href="https://packagist.org/packages/seven.io/magento2"><img src="https://img.shields.io/packagist/v/seven.io/magento2" alt="Packagist" /></a>
</p>

---

## Features

- **Event-based SMS Dispatch** - Triggered automatically on:
  - Customer registration
  - Order submission
  - Order shipment
- **Configurable Templates** - Edit message text per event type from the admin
- **Composer-First Install** - Standard Magento module via Composer

## Prerequisites

- Magento 2.3 or newer
- PHP 7.3+
- A [seven account](https://www.seven.io/) with API key ([How to get your API key](https://help.seven.io/en/developer/where-do-i-find-my-api-key))

## Installation

### Composer (recommended)

```bash
composer require seven/magento2
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:clean
```

### Manual

1. Download the [latest release](https://github.com/seven-io/magento2/releases/latest) ZIP.
2. Extract it into `app/code`.
3. Enable the module:

   - **Magento 2.3.6 and below:** *System > Web Setup Wizard > Component Manager*, then click **Enable** next to `Seven_Api`.
   - **Magento 2.3.7+:** `bin/magento module:enable Seven_Api && php bin/magento setup:upgrade`

## Configuration

In the Magento admin go to **Marketing > Communications > seven**, paste your API key and click **Save Config**. From there you can also tweak the per-event message templates and toggle individual triggers.

## Support

Need help? Feel free to [contact us](https://www.seven.io/en/company/contact/) or [open an issue](https://github.com/seven-io/magento2/issues).

## License

[MIT](LICENSE)
