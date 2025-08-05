<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 24.10.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class PriceTable
 *
 * Description class.
 */
class PriceTable implements OptionSourceInterface
{
    private \Urgent\Base\Model\Api\PriceTable $_priceTable;

    /**
     * Constructor
     *
     * @param \Urgent\Base\Model\Api\PriceTable $priceTable
     */
    public function __construct(\Urgent\Base\Model\Api\PriceTable $priceTable)
    {
        $this->_priceTable = $priceTable;
    }

    /**
     * Method toOptionArray
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $priceTable = $this->_priceTable->execute();
        $options = [];
        if (count($priceTable)) {
            foreach ($priceTable as $price) {
                $options[] = [
                    'value' => $price['PriceTableId'],
                    'label' => $price['Name'],
                ];
            }
        }
        return $options;
    }
}
