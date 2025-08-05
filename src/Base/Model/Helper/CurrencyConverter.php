<?php

declare(strict_types=1);

namespace Urgent\Base\Model\Helper;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class CurrencyConverter
{
    /** @var StoreManagerInterface $storeManager */
    private StoreManagerInterface $storeManager;

    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * @return float|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function backConversionRate(): ?float
    {
        $currentCurrencyRate = $this->getCurrentCurrencyRate();
        $initialMultiplier = $this->calculateInitialMultiplier($currentCurrencyRate);

        if (!empty($initialMultiplier)) {
            return $initialMultiplier;
        }
        return null;
    }

    /**
     * @return float|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function getCurrentCurrencyRate(): ?float
    {
        $store = $this->storeManager->getStore();
        return (float)$store->getCurrentCurrencyRate();
    }

    /**
     * @param float $currentCurrencyRate
     * @return float|null
     */
    public function calculateInitialMultiplier(float $currentCurrencyRate): ?float
    {
        if ($currentCurrencyRate == 0) {
            return null;
        }

        return 1 / $currentCurrencyRate;
    }

}
