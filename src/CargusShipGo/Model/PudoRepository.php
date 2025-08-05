<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 04.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\CargusShipGo\Model\ResourceModel\Pudo as ResourcePudo;
use Magento\Framework\Exception\CouldNotSaveException;
use Urgent\CargusShipGo\Api\Data\PudoInterface;
use Urgent\CargusShipGo\Api\Data\PudoInterfaceFactory;
use Urgent\CargusShipGo\Api\PudoRepositoryInterface;

/**
 * Class PudoRepository
 *
 * Description class.
 */
class PudoRepository implements PudoRepositoryInterface
{
    /** @var ResourcePudo $resource */
    protected ResourcePudo $resource;

    /** @var PudoInterfaceFactory $pudoFactory */
    protected PudoInterfaceFactory $pudoFactory;

    /**
     * Constructor
     *
     * @param ResourcePudo $resource
     * @param PudoInterfaceFactory $pudoFactory
     */
    public function __construct(
        ResourcePudo $resource,
        PudoInterfaceFactory $pudoFactory
    ) {
        $this->resource = $resource;
        $this->pudoFactory = $pudoFactory;
    }

    /**
     * Method save
     *
     * @param PudoInterface $pudo
     *
     * @return PudoInterface
     * @throws CouldNotSaveException
     */
    public function save(PudoInterface $pudo): PudoInterface
    {
        try {
            $this->resource->save($pudo);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save this pudo point: %1',
                $exception->getMessage()
            ));
        }
        return $pudo;
    }

    /**
     * Method getById
     *
     * @param int $id
     *
     * @return PudoInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): PudoInterface
    {
        $pudo = $this->pudoFactory->create();
        $this->resource->load($pudo, $id);
        if (!$pudo->getId()) {
            throw new NoSuchEntityException(__('Pudo point with id "%1" does not exist.', $id));
        }
        return $pudo;
    }

    /**
     * Method getByPudoId
     *
     * @param int $pudoId
     *
     * @return PudoInterface
     * @throws NoSuchEntityException
     */
    public function getByPudoId(int $pudoId): PudoInterface
    {
        $pudo = $this->pudoFactory->create();
        $this->resource->load($pudo, $pudoId, PudoInterface::PUDO_ID);
        if (!$pudo->getId()) {
            throw new NoSuchEntityException(__('Pudo point with id "%1" does not exist.', $pudoId));
        }
        return $pudo;
    }

    /**
     * Method delete
     *
     * @param PudoInterface $pudo
     *
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(PudoInterface $pudo): bool
    {
        try {
            $pudoModel = $this->pudoFactory->create();
            $this->resource->load($pudoModel, $pudo->getId());
            $this->resource->delete($pudoModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the pudo point: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }
}
