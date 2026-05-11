<p align="center">
  <img src="https://www.seven.io/wp-content/uploads/Logo.svg" width="250" alt="seven logo" />
</p>

<h1 align="center">seven SMS for Magento 2</h1>

<p align="center">
  Send transactional SMS for customer registration, order submission and shipment events directly from <a href="https://magento.com/">Magento 2</a> using the <a href="https://www.seven.io">seven.io</a> gateway.
</p>

<p align="center">
  <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-teal.svg" alt="MIT License" /></a>
  <img src="https://img.shields.io/badge/Magento-2.4%2B-orange" alt="Magento 2.4+" />
  <img src="https://img.shields.io/badge/PHP-8.1%2B-purple" alt="PHP 8.1+" />
  <a href="https://packagist.org/packages/seven.io/magento2"><img src="https://img.shields.io/packagist/v/seven.io/magento2" alt="Packagist" /></a>
</p>

---

## Features

- **Event-based SMS dispatch** - fired automatically on:
  - Customer registration
  - Order submission
  - Order shipment
- **Configurable templates per event** - edit message body, toggle per event, target internal-only recipients
- **Placeholder substitution** - inject order number, customer name, tracking URL etc.
- **Composer-first install** - standard Magento 2 module, no marketplace required

## Requirements

| Component | Version |
|-----------|---------|
| Magento   | 2.4.x   |
| PHP       | 8.1 / 8.2 / 8.3 / 8.4 |
| seven.io  | Active account with API key ([how to get one](https://help.seven.io/en/developer/where-do-i-find-my-api-key)) |

## Installation

### Composer (recommended)

```bash
composer require seven.io/magento2
php bin/magento module:enable Seven_Api
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:clean
```

### Manual

1. Download the [latest release](https://github.com/seven-io/magento2/releases/latest) ZIP.
2. Extract its contents into `app/code/Seven/Api/` (create the directory if it does not exist).
3. Enable and register the module:

   ```bash
   php bin/magento module:enable Seven_Api
   php bin/magento setup:upgrade
   php bin/magento setup:di:compile
   php bin/magento cache:clean
   ```

## Configuration

In the Magento admin go to **Stores → Configuration → seven** (or **Marketing → Communications → seven** depending on the Magento version), paste your API key and click **Save Config**.

From there you can also:

- toggle individual triggers (customer registration / order submission / order shipment)
- edit the message template per event
- define additional or default recipients (comma-separated, e.g. `+4915112345678,Peter`)
- mark a trigger as *internal* (sends to the additional recipients only, not to the customer)

### Template placeholders

| Event | Available placeholders |
|-------|------------------------|
| Customer registration | `{0}` first name &nbsp;·&nbsp; `{1}` last name &nbsp;·&nbsp; `{2}` email |
| Order submission      | `{0}` order ID &nbsp;·&nbsp; `{1}` customer name |
| Order shipment        | `{0}` order ID &nbsp;·&nbsp; `{1}` recipient name &nbsp;·&nbsp; `{2}` tracking info (`number(carrier)`, semicolon-separated for multiple parcels) |

Placeholders are substituted with a simple `str_replace` - missing values resolve to an empty string.

## Troubleshooting

**Composer fails with `requires php ^7.0|^7.1|^7.2`**

You are pulling an old release (v1.0.0). Make sure your `composer.json` does not pin to that version, then run `composer update seven.io/magento2`.

**Config section "seven" does not appear in admin**

Re-run `setup:upgrade` and `cache:clean`, then log out and back into the admin once so ACL gets refreshed.

**SMS is not sent on event**

Check `var/log/system.log` - the module logs every dispatch attempt as well as reasons for skipping (missing API key, event disabled, missing phone number).

## Support

Need help? [Contact us](https://www.seven.io/en/company/contact/) or [open an issue](https://github.com/seven-io/magento2/issues).

## License

[MIT](LICENSE)
