<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 09.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Cron\Nomenclature;

use Psr\Log\LoggerInterface;
use Urgent\Base\Model\Config\Config;
use Urgent\Base\Model\UpdateCity;
use Urgent\Base\Model\UpdateCounty;

/**
 * Class Update
 *
 * Description: ...
 */
class Update
{
    /** @var Config $_config */
    private Config $_config;
    /** @var UpdateCounty $_updateCounty */
    private UpdateCounty $_updateCounty;
    /** @var UpdateCity $_updateCity */
    private UpdateCity $_updateCity;
    /** @var LoggerInterface $_logger */
    private LoggerInterface $_logger;

    /**
     * Constructor
     *
     * @param Config $config
     * @param UpdateCounty $updateCounty
     * @param UpdateCity $updateCity
     * @param LoggerInterface $logger
     */
    public function __construct(
        Config       $config,
        UpdateCounty $updateCounty,
        UpdateCity   $updateCity,
        LoggerInterface $logger
    ) {
        $this->_config = $config;
        $this->_updateCounty = $updateCounty;
        $this->_updateCity = $updateCity;
        $this->_logger = $logger;
    }

    /**
     * Method execute
     *
     * @return void
     */
    public function execute(): void
    {
        $this->_logger->info('Cron(urgent_cargus_nomenclature) Started');
        $countries = $this->_config->getNomenclatureSpecificCountry();
        $this->_logger->info('Cron(urgent_cargus_nomenclature) Countries config: ' . $countries);
        if ($countries !== '') {
            $countries = explode(',', $countries);
            $this->_updateCounty->setCollection($countries)->execute();
            $this->_logger->info('Cron(urgent_cargus_nomenclature) Counties inserted or updated.');

            $this->_updateCity->execute();
            $this->_logger->info('Cron(urgent_cargus_nomenclature) Cities inserted or updated.');
        }
        $this->_logger->info('Cron(urgent_cargus_nomenclature) Ended');
    }
}
