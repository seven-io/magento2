<?php declare(strict_types=1);

namespace Sms77\Magento2\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order\Shipment;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;
use Sms77\Api\Client;

class AfterShipment implements ObserverInterface
{
    /** @var LoggerInterface $logger */
    private $logger;

    /** @var ScopeConfigInterface $scopeConfig */
    private $scopeConfig;

    /** @var string $apiKey */
    private $apiKey;

    public function __construct(LoggerInterface $logger, ScopeConfigInterface $scopeConfig)
    {
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;

        $this->apiKey = $this->getConfigValueByKey('general/apiKey');
    }

    private function getConfigValueByKey(string $key)
    {
        return $this->scopeConfig->getValue("sms77/$key", ScopeInterface::SCOPE_STORE);
    }

    public function execute(Observer $observer)
    {
        if (!mb_strlen($this->apiKey)) {
            return;
        }

        /** @var Shipment $shipment */
        $shipment = $observer->getEvent()->getShipment();

        $trackings = [];
        foreach ($shipment->getTracks() as $track) {
            $trackings[] = $track->getTrackNumber() . '(' . $track->getCarrierCode() . ')';
        }
        $trackings = join(';', $trackings);

        $orderId = $shipment->getOrder()->getId();
        $billingAddress = $shipment->getBillingAddress();
        $shippingAddress = $shipment->getShippingAddress();
        $billingPhone = $billingAddress->getTelephone();
        $shippingPhone = $shippingAddress->getTelephone();
        $billingName = $billingAddress->getName();
        $shippingName = $shippingAddress->getName();

        $to = mb_strlen($shippingPhone) ? $shippingPhone : mb_strlen($billingPhone) ? $billingPhone : null;

        if ($to) {
            $name = mb_strlen($shippingName) ? $shippingName : mb_strlen($billingName) ? $billingName : null;
            $tpl = $this->getConfigValueByKey('texts/textOnShipment');

            foreach (['{0}' => $orderId, '{1}' => $name, '{2}' => $trackings] as $k => $v) {
                $tpl = str_replace($k, $v, $tpl);
            }

            (new Client($this->apiKey, 'magento2'))->sms($to, $tpl);

            $this->logger->info('sms77io texting SMS after shipment', [
                'to' => $to,
                'text' => $tpl,
                'name' => $name,
                'orderId' => $orderId,
            ]);
        } else {
            $this->logger->debug('sms77io not texting because of missing phone number.');
        }
    }
}