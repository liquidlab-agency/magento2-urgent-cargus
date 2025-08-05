<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 24.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Adminhtml\Nomenclature;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Urgent\Base\Model\Config\Config;
use Urgent\Base\Model\UpdateCity;
use Urgent\Base\Model\UpdateCounty;

/**
 * Class Update
 *
 * Description: ...
 */
class Update extends Action implements HttpGetActionInterface
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Urgent_Base::config_directory_update';

    /** @var Config $_config */
    private Config $_config;
    /** @var UpdateCounty $_updateCounty */
    private UpdateCounty $_updateCounty;
    /** @var UpdateCity $_updateCity */
    private UpdateCity $_updateCity;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Config $config
     * @param UpdateCounty $updateCounty
     * @param UpdateCity $updateCity
     */
    public function __construct(
        Context      $context,
        Config       $config,
        UpdateCounty $updateCounty,
        UpdateCity   $updateCity
    ) {
        parent::__construct($context);
        $this->_config = $config;
        $this->_updateCounty = $updateCounty;
        $this->_updateCity = $updateCity;
    }

    /**
     * Method execute
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $countries = $this->_config->getNomenclatureSpecificCountry();
        if ($countries !== '') {
            $countries = explode(',', $countries);
            $countCounties = 0;
            $countCities = 0;
            $this->_updateCounty->setCollection($countries)->execute($countCounties);
            $this->_updateCity->execute($countCities);
            $this->messageManager->addSuccessMessage(__('Start updating!') . ' ' .
                $countCounties . ' ' . __('Counties were found') . ', ' . $countCities . ' ' . __('Cities were found'));
        } else {
            $this->messageManager->addErrorMessage(__('No country is selected in the config!'));
        }

        return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
    }
}
