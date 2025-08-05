<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 19.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Ui\Component\Awb\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Actions
 *
 * Description class.
 */
class Actions extends Column
{
    private const URL_PATH_VIEW = 'urgentcargus/awb/view';
    private const URL_PATH_EDIT = 'urgentcargus/awb/edit';
    private const URL_PATH_VALID = 'urgentcargus/awb/validate';
    private const URL_PATH_DELETE = 'urgentcargus/awb/delete';

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
                    // View Action
                    $item[$this->getData('name')]['view'] = [
                        'href' => $this->context->getUrl(self::URL_PATH_VIEW, ['id' => $item['id'],]),
                        'label' => __('View'),
                    ];

                    // Edit Action
                    $item[$this->getData('name')]['edit'] = [
                        'href' => $this->context->getUrl(self::URL_PATH_EDIT, ['id' => $item['id'],]),
                        'label' => __('Edit'),
                    ];

                    // Validate Action
                    $item[$this->getData('name')]['valid'] = [
                        'href' => $this->context->getUrl(self::URL_PATH_VALID, ['id' => $item['id'],]),
                        'label' => __('Validate'),
                        'confirm' => [
                            'title' => __('Validate %1', $item['order_id']),
                            'message' => __('Are you sure you want to validate this %1 record?', $item['order_id'])
                        ],
                        'post' => true,
                    ];

                    // Delete Action
                    $item[$this->getData('name')]['delete'] = [
                        'href' => $this->context->getUrl(self::URL_PATH_DELETE, ['id' => $item['id'],]),
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
}
