<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 31.03.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Cron;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;
use Urgent\CargusShipGo\Api\Data\PudoInterface;
use Urgent\CargusShipGo\Model\Api\GetPudo;

/**
 * Class Pins
 *
 * Cron that get a list of all pudo pins location.
 */
class Pins
{
    private const CONFIG = 'carriers/cargus_shipandgo/';
    private const CONFIG_CHUNK_SIZE = self::CONFIG . 'chunk_list_no';

    /** @var LoggerInterface $_logger */
    private LoggerInterface $_logger;
    /** @var GetPudo $_getPudo */
    private GetPudo $_getPudo;
    /** @var ScopeConfigInterface $_scopeConfig */
    private ScopeConfigInterface $_scopeConfig;
    /** @var ResourceConnection $_resourceConnection */
    private ResourceConnection $_resourceConnection;
    private SerializerInterface $_serializer;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     * @param GetPudo $getPudo
     * @param ScopeConfigInterface $scopeConfig
     * @param ResourceConnection $resourceConnection
     * @param SerializerInterface $serializer
     */
    public function __construct(
        LoggerInterface $logger,
        GetPudo $getPudo,
        ScopeConfigInterface $scopeConfig,
        ResourceConnection $resourceConnection,
        SerializerInterface $serializer
    ) {
        $this->_logger = $logger;
        $this->_getPudo = $getPudo;
        $this->_scopeConfig = $scopeConfig;
        $this->_resourceConnection = $resourceConnection;
        $this->_serializer = $serializer;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        if ($this->_scopeConfig->getValue(self::CONFIG . 'active', ScopeInterface::SCOPE_STORE)) {
            $pudoList = $this->_getPudo->execute();
            $count = count($pudoList);
            if ($count) {
                $this->cleanTable();
                $chunkSize = $this->_scopeConfig
                    ->getValue(self::CONFIG_CHUNK_SIZE, ScopeInterface::SCOPE_STORE);
                $chunkSize = $chunkSize > 0 ? (int)$chunkSize : 100;
                $pudoList = array_chunk($pudoList, $chunkSize);

                $number = 0;
                foreach ($pudoList as $pudoChunk) {
                    $inserted = $this->insertChunk($pudoChunk);
                    $number += $inserted;
                }
                $this->_logger->info("Cron Pudo Inserted: " . $number);
            }
        }
    }

    /**
     * Method insertChunk
     *
     * @param array $pudoChunk
     *
     * @return int
     */
    private function insertChunk(array $pudoChunk): int
    {
        $connection = $this->_resourceConnection->getConnection();
        $table = $this->_resourceConnection->getTableName(PudoInterface::TABLE);

        $data = [];
        foreach ($pudoChunk as $pudo) {
            $check = $connection->select()->from(['UCP' => $table])
                ->where('pudo_id = ?', $pudo['Id']);
            if (!$connection->fetchOne($check)) {
                $data[] = [
                    'pudo_id' => $pudo['Id'],
                    'symbol' => $pudo['Symbol'],
                    'name' => $pudo['Name'],
                    'location_id' => $pudo['LocationId'],
                    'county_id' => $pudo['CountyId'],
                    'county' => ucfirst(strtolower($pudo['County'])),
                    'city_id' => $pudo['CityId'],
                    'city' => ucfirst(strtolower($pudo['City'])),
                    'street_id' => $pudo['StreetId'],
                    'street_name' => $pudo['StreetName'],
                    'zone_id' => $pudo['ZoneId'],
                    'postal_code' => $pudo['PostalCode'],
                    'entrance' => $pudo['Entrance'],
                    'floor' => $pudo['Floor'],
                    'apartment' => $pudo['Apartment'],
                    'sector' => $pudo['Sector'],
                    'address' => $pudo['Address'],
                    'address_description' => $pudo['AddressDescription'],
                    'additional_address_info' => $pudo['AdditionalAddressInfo'],
                    'longitude' => $pudo['Longitude'],
                    'latitude' => $pudo['Latitude'],
                    'point_type' => $pudo['PointType'],
                    'open_hours_mo_start' => $pudo['OpenHoursMoStart'],
                    'open_hours_mo_end' => $pudo['OpenHoursMoEnd'],
                    'open_hours_tu_start' => $pudo['OpenHoursTuStart'],
                    'open_hours_tu_end' => $pudo['OpenHoursTuEnd'],
                    'open_hours_we_start' => $pudo['OpenHoursWeStart'],
                    'open_hours_we_end' => $pudo['OpenHoursWeEnd'],
                    'open_hours_th_start' => $pudo['OpenHoursThStart'],
                    'open_hours_th_end' => $pudo['OpenHoursThEnd'],
                    'open_hours_fr_start' => $pudo['OpenHoursFrStart'],
                    'open_hours_fr_end' => $pudo['OpenHoursFrEnd'],
                    'open_hours_sa_start' => $pudo['OpenHoursSaStart'],
                    'open_hours_sa_end' => $pudo['OpenHoursSaEnd'],
                    'open_hours_su_start' => $pudo['OpenHoursSuStart'],
                    'open_hours_su_end' => $pudo['OpenHoursSuEnd'],
                    'street_no' => $pudo['StreetNo'],
                    'phone_number' => $pudo['PhoneNumber'],
                    'service_cod' => $pudo['ServiceCOD'],
                    'payment_type' => $pudo['PaymentType'],
                    'email' => strtolower($pudo['Email']),
                    'main_picture' => $pudo['MainPicture'],
                    'accepted_payment_type' => $this->_serializer->serialize($pudo['AcceptedPaymentType']),
                ];
            }
        }
        $query = 0;
        $connection->beginTransaction();
        try {
            if (count($data)) {
                $query = $connection->insertMultiple($table, $data);
            }
            $connection->commit();
        } catch (\Exception $exception) {
            $this->_logger->critical($exception->getMessage());
            $connection->rollBack();
        }
        return $query;
    }

    /**
     * Method cleanTable
     *
     * @return void
     */
    private function cleanTable(): void
    {
        $table = $this->_resourceConnection->getTableName(PudoInterface::TABLE);
        $this->_resourceConnection->getConnection()->truncateTable($table);
    }
}
