<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 19.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Ui\Component\Pickup\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Actions
 *
 * Description class.
 */
class Actions extends Column
{
    private const URL_PATH_CANCEL = 'urgentcargus/pickup/cancel';

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
                    // Cancel Action
                    $item[$this->getData('name')]['cancel'] = [
                        'href' => $this->context->getUrl(self::URL_PATH_CANCEL, ['id' => $item['id'],]),
                        'label' => __('Cancel'),
                        'confirm' => [
                            'title' => __('Cancel %1', $item['location_id']),
                            'message' => __('Are you sure you want to cancel this %1 record?', $item['location_id'])
                        ],
                        // SEC-15: POST with form-key CSRF (actions.js posts via mage/dataPost when set).
                        'post' => true,
                    ];
                }
            }
        }

        return $dataSource;
    }
}
