<?php
// app/code/Chandan/ProductInquiry/Ui/Component/Listing/Column/ProductName.php
namespace Chandan\ProductInquiry\Ui\Component\Listing\Column;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class ProductName extends Column
{
    private $productRepository;

    public function __construct(
        ContextInterface $context,
        ProductRepositoryInterface $productRepository,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $components, $data);
        $this->productRepository = $productRepository;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['product_id'])) {
                    $product = $this->productRepository->getById($item['product_id']);
                    $item['product_name'] = $product->getName();
                }
            }
        }
        return $dataSource;
    }
}
