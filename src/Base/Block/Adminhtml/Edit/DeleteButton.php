<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 20.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Urgent\Base\Api\AwbRepositoryInterface;

/**
 * Class DeleteButton
 *
 * Description back button.
 */
class DeleteButton implements ButtonProviderInterface
{
    /** @var Context $_context */
    protected Context $_context;
    /** @var AwbRepositoryInterface $_awbRepository\ */
    protected AwbRepositoryInterface $_awbRepository;

    /**
     * Constructor
     *
     * @param Context $context
     * @param AwbRepositoryInterface $awbRepository
     */
    public function __construct(
        Context $context,
        AwbRepositoryInterface $awbRepository
    ) {
        $this->_context = $context;
        $this->_awbRepository = $awbRepository;
    }

    /**
     * Method getButtonData
     * @return array
     */
    public function getButtonData(): array
    {
        $data = [];
        try {
            $awbId = $this->_context->getRequest()->getParam('id');
            $awb =  $this->_awbRepository->getById((int)$awbId);
        } catch (NoSuchEntityException $e) {
            return $data;
        }
        if ($awb->getId()) {
            $deleteUrl = $this->_context->getUrlBuilder()->getUrl('*/*/delete', ['id' => $awb->getId()]);
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to do this?') . '\', \'' .
                    $deleteUrl . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }
}
