<?php

namespace BlueMedia\BluePayment\Block;

use BlueMedia\BluePayment\Model\ResourceModel\Gateways\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Form
 *
 * @package BlueMedia\BluePayment\Block
 */
class Form extends \Magento\Payment\Block\Form
{
    /**
     * @var string
     */
    protected $_template = 'BlueMedia_BluePayment::bluepayment/form.phtml';

    /**
     * @var array
     */
    protected $_gatewayList = [];

    /**
     * @var \BlueMedia\BluePayment\Model\ResourceModel\Gateways\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Form constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context                      $context
     * @param \BlueMedia\BluePayment\Model\ResourceModel\Gateways\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface                    $scopeConfig
     * @param array                                                                 $data
     */
    public function __construct(
        Context           $context,
        CollectionFactory $collectionFactory,
        ScopeConfigInterface $scopeConfig,
        array             $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->scopeConfig  = $scopeConfig;
    }

    /**
     * @return array
     */
    public function getGatewaysList()
    {
        if (!$this->_gatewayList) {
            $this->_gatewayList = $this->collectionFactory->create();
            $this->_gatewayList
                ->addFieldToFilter('gateway_status', 1)
                ->addFieldToFilter('force_disable', 0)
                ->load();
        }

        return $this->_gatewayList;
    }

    /**
     * Zwraca adres do logo firmy
     *
     * @return string|bool
     */
    public function getLogoSrc()
    {
        $logo_src = $this->getViewFileUrl('BlueMedia_BluePayment::images/logo.jpg');

        return $logo_src != '' ? $logo_src : false;
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getMethodTitle()
    {
        return __('Quick online payment');
    }

    public function getTitleAutomatic()
    {
        return $this->scopeConfig->getValue("payment/bluepayment/title_automatic");
    }

    public function getTitleBlik()
    {
        return $this->scopeConfig->getValue("payment/bluepayment/title_blik");
    }
}
