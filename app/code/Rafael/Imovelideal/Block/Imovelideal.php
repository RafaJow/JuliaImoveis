<?php
namespace Rafael\Imovelideal\Block;

use Magento\Backend\Block\Template\Context;

class Imovelideal extends \Magento\Framework\View\Element\Template
{
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getFormAction()
    {
        return '/imovelideal/index/save';
        // return $this->getUrl('/imovelideal/index/save', ['_secure' => true]);
    }
}