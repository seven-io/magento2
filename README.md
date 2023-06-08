![](https://www.seven.io/wp-content/uploads/Logo.svg "seven Logo")

# Module for Magento 2

## Installation

*Via Composer*

1. `composer require seven/magento2`
2. `php bin/magento setup:upgrade`
3. `php bin/magento setup:di:compile`
4. `php bin/magento cache:clean`

*Manually*

1. Download the latest [release](https://github.com/seven-io/magento2-module/releases/latest) as *
   .zip
2. Extract the archive to `/app/code`
3. 
    2.3.6 and below:
      1. Navigate to `System->Web Setup Wizard->Component Manager`
      2. Hover over the "Actions" column and click it to press "Enable"
   
    2.3.7+: 
      1. `bin/magento module:enable Seven_Api`

In both cases, you will need to set your API key in order to send SMS. In the Magento
backend, navigate to `Marketing.Communications->seven` and type it in. Do not forget to
click on "Save Config".

### Functionalities

*Event-based SMS dispatch at:*

- Customer Registration
- Order Shipment
- Order Submission

#### Support

Need help? Feel free to [contact us](https://www.seven.io/en/company/contact).

[![MIT](https://img.shields.io/badge/License-MIT-teal.svg)](LICENSE)
