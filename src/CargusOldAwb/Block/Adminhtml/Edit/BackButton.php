<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 20.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusOldAwb\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class BackButton
 *
 * Description back button.
 */
class BackButton implements ButtonProviderInterface
{
    /** @var Context $_context */
    protected Context $_context;

    /**
     * Constructor
     *
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->_context = $context;
    }

    /**
     * Method getButtonData
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->_context->getUrlBuilder()->getUrl('*/*/')),
            'class' => 'back',
            'sort_order' => 10
        ];
    }
}
