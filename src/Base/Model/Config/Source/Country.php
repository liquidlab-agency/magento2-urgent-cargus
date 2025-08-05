<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 11.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Urgent\Base\Api\Data\CountryInterface;
use Urgent\Base\Model\ResourceModel\Nomenclature\Country\CollectionFactory;

/**
 * Class Country
 *
 * Description: ...
 */
class Country implements OptionSourceInterface
{
    /** @var CollectionFactory $_collectionFactory */
    private CollectionFactory $_collectionFactory;

    /**
     * Constructor
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->_collectionFactory = $collectionFactory;
    }

    /**
     * Method toOptionArray
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $countries = $this->_collectionFactory->create();
        $options = [];
        if (count($countries)) {
            /** @var CountryInterface $country */
            foreach ($countries as $country) {
                $options[] = [
                    'value' => $country->getId(),
                    'label' => $country->getCountryName()
                ];
            }
        }
        return $options;
    }
}
