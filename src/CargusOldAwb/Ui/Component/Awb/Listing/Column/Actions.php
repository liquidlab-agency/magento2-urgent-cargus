<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 19.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusOldAwb\Ui\Component\Awb\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Actions
 *
 * Description class.
 */
class Actions extends Column
{
    private const URL_PATH_VIEW = 'cargus_old/awb/view';

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
                    $item[$this->getData('name')] = [
                        'view' => [
                            'href' => $this->context->getUrl(self::URL_PATH_VIEW, ['id' => $item['id'],]),
                            'label' => __('View'),
                        ],
                    ];
                }
            }
        }

        return $dataSource;
    }
}
