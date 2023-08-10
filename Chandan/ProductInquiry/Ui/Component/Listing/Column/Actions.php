<?php

// app/code/Chandan/ProductInquiry/Ui/Component/Listing/Column/Actions.php
namespace Chandan\ProductInquiry\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    const URL_PATH_REPLY = 'productinquiry/inquiry/sendreply';

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['inquiry_id'])) {
                    $item[$name]['send_reply'] = [
                        'href' => $this->urlBuilder->getUrl(
                            self::URL_PATH_REPLY,
                            ['id' => $item['inquiry_id']]
                        ),
                        'label' => __('Send Reply Email'),
                        'hidden' => false,
                    ];
                }
            }
        }

        return $dataSource;
    }
}
