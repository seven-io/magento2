<?php declare(strict_types=1);

namespace Sms77\Magento2\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Sales\Model\Order\Shipment;
use Psr\Log\LoggerInterface;

class AfterShipment extends BaseObserver {
    public function __construct(LoggerInterface $logger, ScopeConfigInterface $scopeConfig) {
        parent::__construct($logger, $scopeConfig, 'event_on_shipment');
    }

    public function execute(Observer $observer) {
        if (!$this->isValid) {
            return;
        }

        /** @var Shipment $shipment */
        $shipment = $observer->getEvent()->getShipment();
        $billingAddress = $shipment->getBillingAddress();
        $billingName = $billingAddress->getName();
        $shippingAddress = $shipment->getShippingAddress();
        $shippingName = $shippingAddress->getName();

        $this->send([$shippingAddress, $billingAddress], [
            $shipment->getOrder()->getId(),
            mb_strlen($shippingName) ? $shippingName : mb_strlen($billingName) ? $billingName : null,
            join(';', array_map(function($track) {
                return $track->getTrackNumber() . '(' . $track->getCarrierCode() . ')';
            }, $shipment->getTracks()))]);
    }
}