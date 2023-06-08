<?php declare(strict_types=1);

namespace Seven\Magento2\Observer;

use Magento\Customer\Model\Data\Customer;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;

class AfterCustomerRegistration extends BaseObserver {
    public function __construct(LoggerInterface $logger, ScopeConfigInterface $scopeConfig) {
        parent::__construct($logger, $scopeConfig, 'event_on_customer_reg');
    }

    public function execute(Observer $observer) {
        if (!$this->isValid) {
            return;
        }

        /** @var Customer $customer */
        $customer = $observer->getEvent()->getCustomer();

        $this->send(
            $customer->getAddresses() ?? [], [
            $customer->getFirstname(),
            $customer->getLastname(),
            $customer->getEmail(),
        ]);
    }
}
