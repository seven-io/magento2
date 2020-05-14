<?php declare(strict_types=1);

namespace Sms77\Magento2\Observer;

use Magento\Customer\Model\Data\Customer;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;

class AfterCheckoutSubmitAllAfter extends BaseObserver {
    public function __construct(LoggerInterface $logger, ScopeConfigInterface $scopeConfig) {
        parent::__construct($logger, $scopeConfig, 'event_on_submit_order');
    }

    public function execute(Observer $observer) {
        if (!$this->isValid) {
            return;
        }

        /** @var Order $order */
        $order = $observer->getEvent()->getOrder();

        $this->send(
            $order->getAddresses() ?? [], [
            $order->getId(),
            $order->getCustomerName(),
        ]);
    }
}