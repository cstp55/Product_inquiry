<?php

namespace Chandan\ProductInquiry\ViewModel;

use Magento\Framework\UrlInterface;

class ConfigViewModel implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /** @var _config  */
    protected $_config;

    protected $helper;

    protected $configProvider;

    /** @var UrlInterface */
    protected $urlBuilder;

    /** @var SerializerInterface */
    protected $serializer;

    public function __construct(
        \Webkul\OrderByWhatsappBot\Helper\Data $helper,
        UrlInterface $urlBuilder,
        \Magento\Framework\Serialize\Serializer\Json $serializer = null,
        \Magento\Framework\Serialize\SerializerInterface $serializerInterface = null,
    ) {
        $this->configProvider = $configProvider;
        $this->urlBuilder = $urlBuilder;
        $this->helper = $helper;
        $this->serializer = $serializerInterface ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Framework\Serialize\Serializer\JsonHexTag::class);
    }

    /**
     * Get Config
     *
     * @return void
     */
    public function getConfig()
    {
        if (!$this->_config) {
            $this->_config = $this->helper->getConfig();
        }
        return $this->_config;
    }


    /**
     * Is require whatsapp number field
     *
     * @return boolean
     */
    public function IsModuleEnable()
    {
        return (bool) $this->getConfig();
    }

}