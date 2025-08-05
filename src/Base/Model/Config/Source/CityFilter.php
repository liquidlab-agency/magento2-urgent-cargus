<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 11.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Config\Source;

use Urgent\Base\Api\Data\CityInterface;
use Urgent\Base\Model\Config\Config;
use Magento\Framework\Data\OptionSourceInterface;
use Urgent\Base\Model\ResourceModel\Nomenclature\City\CollectionFactory;

/**
 * Class CityFilter
 *
 * Description: ...
 */
class CityFilter implements OptionSourceInterface
{
    /** @var CollectionFactory $_collectionFactory */
    private CollectionFactory $_collectionFactory;
    /** @var Config $_config */
    private Config $_config;

    /**
     * Constructor
     *
     * @param CollectionFactory $collectionFactory
     * @param Config $config
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Config            $config
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_config = $config;
    }

    /**
     * Method toOptionArray
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $options[] = [
            'value' => 0,
            'label' => __('Please select')
        ];

        $countyId = $this->_config->getLocationCounty();
        if ($countyId > 0) {
            $counties = $this->_collectionFactory->create();
            $counties->addFieldToFilter(CityInterface::COUNTY_ID, ['eq' => $countyId]);
            if (count($counties)) {
                /** @var CityInterface $city */
                foreach ($counties as $city) {
                    $options[] = [
                        'value' => $city->getId(),
                        'label' => ucfirst(strtolower($city->getName()))
                    ];
                }
            }
        }

        return $options;
    }
}
