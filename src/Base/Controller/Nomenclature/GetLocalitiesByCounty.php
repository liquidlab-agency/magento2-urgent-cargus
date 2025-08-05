<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 16.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Nomenclature;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Api\CityRepositoryInterface;
use Urgent\Base\Api\CountyRepositoryInterface;

/**
 * Class GetLocalitiesByCounty
 *
 * Description: ...
 */
class GetLocalitiesByCounty implements HttpGetActionInterface
{
    /** @var RequestInterface $_request */
    protected RequestInterface $_request;
    /** @var ResultFactory $_resultFactory */
    protected ResultFactory $_resultFactory;
    /** @var CountyRepositoryInterface $_countyRepository */
    protected CountyRepositoryInterface $_countyRepository;
    /** @var CityRepositoryInterface $_cityRepository */
    protected CityRepositoryInterface $_cityRepository;

    /**
     * Constructor
     *
     * @param RequestInterface $request
     * @param ResultFactory $resultFactory
     * @param CountyRepositoryInterface $countyRepository
     * @param CityRepositoryInterface $cityRepository
     */
    public function __construct(
        RequestInterface          $request,
        ResultFactory             $resultFactory,
        CountyRepositoryInterface $countyRepository,
        CityRepositoryInterface   $cityRepository
    ) {
        $this->_request = $request;
        $this->_resultFactory = $resultFactory;
        $this->_countyRepository = $countyRepository;
        $this->_cityRepository = $cityRepository;
    }

    /**
     * Method execute
     *
     * @return array|ResponseInterface|Json|(Json&ResultInterface)|ResultInterface
     */
    public function execute()
    {
        /** @var null|string $countyName */
        $countyName = $this->_request->getParam('county_name');
        $result = $this->_resultFactory->create(ResultFactory::TYPE_JSON);
        $response = [
            'error' => false,
            'message' => ''
        ];
        if ($countyName !== '' && $countyName !== null) {
            if ($countyName === 'self') {
                $response['error'] = true;
                return $result->setData($response);
            }
            try {
                $county = $this->_countyRepository->getByName($countyName);
                if ($county->getId()) {
                    $localities = $this->_cityRepository->getByCountyId((int)$county->getId());
                    if (count($localities)) {
                        $response['localities'] = $localities;
                        return $result->setData($response);
                    }
                    $response['error'] = true;
                    $response['message'] = __('No localities where found!');
                    return $result->setData($response);
                }
            } catch (LocalizedException|NoSuchEntityException $e) {
                $response['error'] = true;
                $response['message'] = __('Something goes wrong in the process to get localities from cargus!');
                return $result->setData($response);
            }

            $response['error'] = true;
            $response['message'] = __('No county was found with %1 name!', $countyName);
            return $result->setData($response);
        }

        $response['error'] = true;
        $response['message'] = __('County name is empty!');
        return $result->setData($response);
    }
}
