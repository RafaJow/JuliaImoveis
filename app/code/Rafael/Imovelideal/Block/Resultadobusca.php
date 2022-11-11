<?php

namespace Rafael\Imovelideal\Block;

use Magento\Backend\Block\Template\Context;

class Resultadobusca extends \Magento\Framework\View\Element\Template
{
    protected $resource;
    
    public function __construct(
        Context $context, 
        array $data = [],
        \Magento\Framework\App\ResourceConnection $resource
    )
    {
        $this->_resource = $resource;
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getImoveisSelecionados(){
        return 'funcionou';
    }
}