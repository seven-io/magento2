<?php declare(strict_types=1);

namespace Sms77\Magento2\Observer;

use Exception;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order\Address as OrderAddress;
use Psr\Log\LoggerInterface;
use Sms77\Api\Client;

abstract class BaseObserver implements ObserverInterface {
    /** @var LoggerInterface $logger */
    protected $logger;

    /** @var ScopeConfigInterface $scopeConfig */
    protected $scopeConfig;

    /** @var string $apiKey */
    protected $apiKey;

    /** @var string $eventName */
    protected $eventName;

    /** @var bool $isValid */
    protected $isValid;

    public function __construct(LoggerInterface $logger, ScopeConfigInterface $scopeConfig, string $eventName) {
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
        $this->eventName = $eventName;
        $this->apiKey = $this->getConfigValueByKey('general/apiKey');
        $this->isValid = $this->isValid();
    }

    protected function getConfigValueByKey(string $key) {
        return $this->scopeConfig->getValue("sms77/$key");
    }

    private function isValid() {
        if (!mb_strlen($this->apiKey)) {
            $this->logger->info('API is missing.');

            return false;
        }

        if (!(bool)$this->getConfigValueByKey("$this->eventName/enabled")) {
            $this->logger->info('Event not enabled.');

            return false;
        }

        return true;
    }

    protected function send(array $addresses, array $placeholders) {
        try {
            $tpl = $this->getConfigValueByKey("$this->eventName/text");
            foreach ($placeholders as $k => $v) {
                $tpl = str_replace('{' . $k . '}', $v, $tpl);
            }

            $to = '';
            foreach ($addresses as $address) {
                $tel = $address->getTelephone();

                if ($tel) {
                    $to = $tel;
                }

                if (false === $address instanceof OrderAddress) {
                    if ($address->isDefaultShipping() || $address->isDefaultBilling()) {
                        break;
                    }
                }
            }

            if (!mb_strlen($to)) {
                $this->logger->info('sms77io not texting because of missing phone number.');
                return;
            }

            $this->logger->info("sms77io texting SMS $this->eventName",
                [(new Client($this->apiKey, 'magento2'))
                    ->sms($to, $tpl, ['json' => 1])]);
        } catch (Exception $ex) {
            $this->logger->debug($ex->getMessage());
        }
    }
}