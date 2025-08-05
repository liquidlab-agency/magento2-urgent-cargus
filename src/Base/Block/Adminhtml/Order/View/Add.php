<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 27.06.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Block\Adminhtml\Order\View;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Sales\Block\Adminhtml\Order\View;
use Magento\Sales\Helper\Reorder;
use Magento\Sales\Model\ConfigInterface;
use Urgent\Base\Api\AwbRepositoryInterface;

/**
 * Class Add
 *
 * Description: Add this order to cargus delivery grid.
 */
class Add extends View
{
    /** @var AwbRepositoryInterface $awbRepository */
    protected AwbRepositoryInterface $awbRepository;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $registry
     * @param ConfigInterface $salesConfig
     * @param Reorder $reorderHelper
     * @param AwbRepositoryInterface $awbRepository
     * @param array $data
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function __construct(
        Context                $context,
        Registry               $registry,
        ConfigInterface        $salesConfig,
        Reorder                $reorderHelper,
        AwbRepositoryInterface $awbRepository,
        array                  $data = []
    ) {
        parent::__construct($context, $registry, $salesConfig, $reorderHelper, $data);
        $this->awbRepository = $awbRepository;
        $order = $this->getOrder();

        if ($this->_isAllowedAction('Urgent_Base::urgentcargus_mass_action_add') &&
            !$order->isCanceled() &&
            $this->awbRepository->getByIncrementId($order->getIncrementId()) === null) {
            $this->addButton(
                'order_add_cargus',
                [
                    'label' => __('Add to Cargus'),
                    'id' => 'order-view-add-cargus-button',
                    'onclick' => 'setLocation(\'' . $this->getUrl('urgentcargus/order/add') . '\')'
                ]
            );
        }
    }
}
