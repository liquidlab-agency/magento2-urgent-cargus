<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 29.06.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Api\Data\PickupInterface;
use Urgent\Base\Api\PickupRepositoryInterface;
use Urgent\Base\Model\PickupFactory;

/**
 * Class PickupRepository
 *
 * Description: ...
 */
class PickupRepository implements PickupRepositoryInterface
{
    /** @var ResourceModel\Pickup $_pickupResource */
    protected ResourceModel\Pickup $_pickupResource;
    /** @var \Urgent\Base\Model\PickupFactory $_pickupFactory */
    protected \Urgent\Base\Model\PickupFactory $_pickupFactory;

    /**
     * Constructor
     *
     * @param ResourceModel\Pickup $pickupResource
     * @param \Urgent\Base\Model\PickupFactory $pickupFactory
     */
    public function __construct(
        \Urgent\Base\Model\ResourceModel\Pickup $pickupResource,
        PickupFactory                           $pickupFactory
    ) {
        $this->_pickupResource = $pickupResource;
        $this->_pickupFactory = $pickupFactory;
    }

    /**
     * @inheritDoc
     */
    public function save(PickupInterface $pickup): PickupInterface
    {
        try {
            $this->_pickupResource->save($pickup);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $pickup;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): PickupInterface
    {
        $pickup = $this->_pickupFactory->create();
        $this->_pickupResource->load($pickup, $id);
        if (!$pickup->getId()) {
            throw new NoSuchEntityException(__('The pickup with the "%1" ID doesn\'t exist.', $id));
        }
        return $pickup;
    }

    /**
     * @inheritDoc
     */
    public function delete(PickupInterface $pickup): bool
    {
        try {
            $this->_pickupResource->delete($pickup);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }
}
