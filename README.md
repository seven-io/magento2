<p align="center">
    <img src="https://www.sms77.io/wp-content/uploads/2019/07/sms77-Logo-400x79.png" alt="" />
</p>

# sms77io Module for Magento 2

## Installation
<figure>
    <figcaption>Via Composer</figcaption>
    <ol>
        <li><code>composer require sms77/magento2</code></li>
        <li><code>php bin/magento setup:upgrade</code></li>
        <li><code>php bin/magento setup:di:compile</code></li>
        <li><code>php bin/magento cache:clean</code></li>
    </ol>
</figure>

<figure>
    <figcaption>Manually</figcaption>
    <ol>
        <li>Head over to <a href='https://github.com/sms77io/magento2-module/releases'>Releases</a> and download the latest *.zip package</li>
        <li>Extract the archive to /app/code</li>
        <li>Navigate to System->Web Setup Wizard->Component Manager</li>
        <li>Hover over the "Actions" columnn and click it to press "Enable"</li>
    </ol>
</figure>

In both cases, you will need to set your API key in order to send SMS.
In the Magento backend, navigate to Marketing.Communications->sms77io and type it in.
Do not forget to click on "Save Config".

### Event-based SMS dispatch at:
- Order Shipment
- Customer Registration

#### ToDo
- Add more Events
- Add Bulk SMS
- Tests
- Translation