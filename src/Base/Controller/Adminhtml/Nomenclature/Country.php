<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 11.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Adminhtml\Nomenclature;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Urgent\Base\Model\UpdateCountry;

/**
 * Class Country
 *
 * Description: ...
 */
class Country extends Action implements HttpGetActionInterface
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Urgent_Base::config_directory_update';

    /** @var UpdateCountry $_updateCountry */
    private UpdateCountry $_updateCountry;

    /**
     * Constructor
     *
     * @param Context $context
     * @param UpdateCountry $updateCountry
     */
    public function __construct(
        Context       $context,
        UpdateCountry $updateCountry
    ) {
        parent::__construct($context);
        $this->_updateCountry = $updateCountry;
    }

    /**
     * Method execute
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $countries = $this->_updateCountry->execute();
        $countCountries = count($countries);
        if ($countCountries) {
            $this->messageManager
                ->addSuccessMessage(__('Success!') . ' ' . $countCountries . ' ' . __('Countries were found'));
        } else {
            $this->messageManager->addErrorMessage(__('Something went wrong! Please try again.'));
        }
        return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
    }
}
