<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 31.03.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\View\Asset\Repository;
use Urgent\CargusShipGo\Api\Data\PudoInterface;

/**
 * Class CheckoutConfigProvider
 *
 * Description class.
 */
class CheckoutConfigProvider implements ConfigProviderInterface
{
    public const CARGUS = 'cargus';
    public const ICONS = 'icons';
    public const PIN = 'pin';
    public const LOCKER = 'locker';
    public const STORE = 'store';
    public const WORK = 'work';
    public const PAY = 'pay';
    public const PINS = 'pins';

    private array $_config = [];

    /** @var Repository $_assetRepo */
    private Repository $_assetRepo;
    /** @var ResourceConnection $_resourceConnection */
    private ResourceConnection $_resourceConnection;

    /**
     * @param Repository $assetRepo
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        Repository $assetRepo,
        ResourceConnection $resourceConnection
    ) {
        $this->_assetRepo = $assetRepo;
        $this->_resourceConnection = $resourceConnection;
    }

    /**
     * Method getConfig
     *
     * @return array
     */
    public function getConfig(): array
    {
        $this->getIcons();
        $this->getPins();
        return $this->_config;
    }

    /**
     * Method getIcon
     *
     */
    private function getIcons(): void
    {
        $this->_config[self::CARGUS][self::ICONS][self::PIN] = $this->_assetRepo
            ->getUrl("Urgent_CargusShipGo::images/pin.svg");
        $this->_config[self::CARGUS][self::ICONS][self::LOCKER] = $this->_assetRepo
            ->getUrl("Urgent_CargusShipGo::images/locker.svg");
        $this->_config[self::CARGUS][self::ICONS][self::STORE] = $this->_assetRepo
            ->getUrl("Urgent_CargusShipGo::images/store.svg");
        $this->_config[self::CARGUS][self::ICONS][self::WORK] = $this->_assetRepo
            ->getUrl("Urgent_CargusShipGo::images/work.svg");
        $this->_config[self::CARGUS][self::ICONS][self::PAY] = $this->_assetRepo
            ->getUrl("Urgent_CargusShipGo::images/pay.svg");
    }

    /**
     * Method getPins
     *
     */
    private function getPins(): void
    {
        $connection = $this->_resourceConnection->getConnection();
        $table = $this->_resourceConnection->getTableName(PudoInterface::TABLE);
        $query = $connection->select()->from(['UCP' => $table]);
        $result = $connection->fetchAll($query);
        $this->_config[self::CARGUS][self::PINS] = count($result) ? $result : [];
    }
}
