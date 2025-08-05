<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 19.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model;

use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Api\AwbRepositoryInterface;
use Urgent\Base\Api\Data\AwbInterface;
use Urgent\Base\Model\ResourceModel\Awb as AwbResource;
use Urgent\Base\Model\AwbFactory;

/**
 * Class AwbRepository
 *
 * Description class.
 */
class AwbRepository implements AwbRepositoryInterface
{
    /** @var AwbResource $_awbResource */
    protected AwbResource $_awbResource;
    /** @var AwbFactory $_awbFactory */
    protected AwbFactory $_awbFactory;

    /**
     * Constructor
     *
     * @param AwbResource $awbResource
     * @param AwbFactory $awbFactory
     */
    public function __construct(
        AwbResource $awbResource,
        AwbFactory  $awbFactory
    ) {
        $this->_awbResource = $awbResource;
        $this->_awbFactory = $awbFactory;
    }

    /**
     * Method save
     *
     * @param AwbInterface $awb
     *
     * @return AwbInterface
     * @throws CouldNotSaveException
     */
    public function save(AwbInterface $awb): AwbInterface
    {
        try {
            $this->_awbResource->save($awb);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $awb;
    }

    /**
     * Method getById
     *
     * @param int $id
     *
     * @return AwbInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): AwbInterface
    {
        $awb = $this->_awbFactory->create();
        $this->_awbResource->load($awb, $id, AwbInterface::ID);
        if (!$awb->getId()) {
            throw new NoSuchEntityException(__('The AWB with the "%1" ID doesn\'t exist.', $id));
        }
        return $awb;
    }

    /**
     * Method getByIncrementId
     *
     * @param string $incrementId
     * @return AwbInterface|null
     */
    public function getByIncrementId(string $incrementId): ?AwbInterface
    {
        $awb = $this->_awbFactory->create();
        $this->_awbResource->load($awb, $incrementId, AwbInterface::ORDER_ID);
        if (!$awb->getId()) {
            return null;
        }
        return $awb;
    }

    /**
     * Method getByAwbCode
     *
     * @param string $awbNo
     * @return AwbInterface
     * @throws NoSuchEntityException
     */
    public function getByAwbCode(string $awbNo): AwbInterface
    {
        $awb = $this->_awbFactory->create();
        $this->_awbResource->load($awb, $awbNo, AwbInterface::AWB_NO);
        if (!$awb->getId()) {
            throw new NoSuchEntityException(__('The AWB with this number "%1" doesn\'t exist.', $awbNo));
        }
        return $awb;
    }

    /**
     * Method getByAwbOrderId
     *
     * @param int $orderId
     * @return AwbInterface
     * @throws NoSuchEntityException
     */
    public function getByAwbOrderId(int $orderId): AwbInterface
    {
        $awb = $this->_awbFactory->create();
        $this->_awbResource->load($awb, $orderId, AwbInterface::ORDER_ID);
        if (!$awb->getId()) {
            throw new NoSuchEntityException(__('The AWB with this order ID: "%1" doesn\'t exist.', $orderId));
        }
        return $awb;
    }

    /**
     * Method delete
     *
     * @param AwbInterface $awb
     *
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(AwbInterface $awb): bool
    {
        try {
            $this->_awbResource->delete($awb);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }
}
