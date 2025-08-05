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
use Urgent\Base\Api\Data\CountyInterface;
use Urgent\Base\Model\ResourceModel\Nomenclature\County\CollectionFactory;

/**
 * Class County
 *
 * Description: ...
 */
class County implements OptionSourceInterface
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
        $counties = $this->_collectionFactory->create();
        $options = [];
        if (count($counties)) {
            /** @var CountyInterface $county */
            foreach ($counties as $county) {
                $options[] = [
                    'value' => $county->getId(),
                    'label' => $county->getName() . ' (' . $county->getAbbreviation() . ')'
                ];
            }
        }
        $keyValues = array_column($options, 'label');
        array_multisort($keyValues, SORT_ASC, $options);
        array_unshift($options, ['value' => 0, 'label' => __('Please select')]);
        return $options;
    }
}
