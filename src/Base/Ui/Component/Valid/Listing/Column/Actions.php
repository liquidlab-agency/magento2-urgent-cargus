<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 19.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Ui\Component\Valid\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Urgent\Base\Model\Config\Config;

/**
 * Class Actions
 *
 * Description class.
 */
class Actions extends Column
{
    private const URL_PATH_VIEW = 'urgentcargus/valid/view';
    private const URL_PATH_PRINT = 'urgentcargus/valid/printawb';
    private const URL_PATH_DELETE = 'urgentcargus/valid/delete';

    public const TYPE_PRINT_ONLY_AWB = 0;
    public const TYPE_PRINT_AWB_AND_RETURN_STANDARD = 1;
    public const TYPE_PRINT_AWB_AND_RETURN_WITH_INFO = 2;
    public const TYPE_PRINT_ONLY_RETURN_AWB_STANDARD = 3;
    public const TYPE_PRINT_ONLY_RETURN_AWB_WITH_INFO = 4;

    /** @var Config $_config */
    private Config $_config;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Config $config
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        Config             $config,
        array              $components = [],
        array              $data = []
    ) {
        $this->_config = $config;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Method prepareDataSource
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['id'])) {
                    $itemId = (int)$item['id'];
                    // View Action
                    $item[$this->getData('name')]['view'] = [
                        'href' => $this->context->getUrl(self::URL_PATH_VIEW, ['id' => $itemId]),
                        'label' => __('View'),
                        'popup' => true,
                        'target' => '_blank',
                    ];

                    switch ($this->_config->getGeneralConsumerReturn()) {
                        case 1:
                        case 2:
                            $item[$this->getData('name')]['print_awb'] = $this->getPrintButton(
                                $itemId,
                                self::TYPE_PRINT_ONLY_AWB,
                                'Print AWB'
                            );
                            $item[$this->getData('name')]['print_awb_return_standard'] = $this->getPrintButton(
                                $itemId,
                                self::TYPE_PRINT_AWB_AND_RETURN_STANDARD,
                                'Print AWB + Return AWB Standard'
                            );
                            $item[$this->getData('name')]['print_awb_return_with_info'] = $this->getPrintButton(
                                $itemId,
                                self::TYPE_PRINT_AWB_AND_RETURN_WITH_INFO,
                                'Print AWB + Return AWB With Instructions'
                            );
                            $item[$this->getData('name')]['print_return_standard'] = $this->getPrintButton(
                                $itemId,
                                self::TYPE_PRINT_ONLY_RETURN_AWB_STANDARD,
                                'Print Return AWB Standard'
                            );
                            $item[$this->getData('name')]['print_return_with_info'] = $this->getPrintButton(
                                $itemId,
                                self::TYPE_PRINT_ONLY_RETURN_AWB_WITH_INFO,
                                'Print Return AWB With Instructions'
                            );
                            break;
                        default:
                            $item[$this->getData('name')]['print_awb'] = $this->getPrintButton(
                                $itemId,
                                self::TYPE_PRINT_ONLY_AWB,
                                'Print AWB'
                            );
                            break;
                    }
                    // Print Action

                    // Delete Action
                    $item[$this->getData('name')]['delete'] = [
                        'href' => $this->context->getUrl(self::URL_PATH_DELETE, ['id' => $itemId]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete %1', $item['order_id']),
                            'message' => __('Are you sure you want to delete a %1 record?', $item['order_id'])
                        ],
                        'post' => true,
                    ];
                }
            }
        }

        return $dataSource;
    }

    /**
     * Method getPrintButton
     *
     * @param int $id
     * @param int $type
     * @param string $label
     * @return array
     */
    private function getPrintButton(int $id, int $type, string $label): array
    {
        return [
            'href' => $this->context->getUrl(self::URL_PATH_PRINT, ['id' => $id, 'print_type' => $type]),
            'label' => __($label),
            'popup' => true,
            'target' => '_blank',
        ];
    }
}
