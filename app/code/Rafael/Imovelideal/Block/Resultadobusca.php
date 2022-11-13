<?php

namespace Rafael\Imovelideal\Block;

use Magento\Backend\Block\Template\Context;

class Resultadobusca extends \Magento\Framework\View\Element\Template
{
    protected $resource;

    protected $_productRepository;
    
    public function __construct(
        Context $context, 
        array $data = [],
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Catalog\Model\ProductRepository $productRepository
    )
    {
        $this->_resource = $resource;
        $this->_productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getImoveisSelecionados($email){
        try{
            $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/resultado_busca_block.log');
            $logger = new \Zend_Log();
            $logger->addWriter($writer);

            $run = shell_exec('~/projects/python/SistemaEspecialista/imovel.py');

            $query = "SELECT * FROM imovel_cliente WHERE email like '".$email."'";
            $connection = $this->_resource->getConnection();
            $result = $connection->fetchAll($query); // select

            return $result;
            
        }catch(\Exception $e){
            $logger->info('exception: '.$e->getMessage());
        }
    }

    public function getProductById($id)
	{
		return $this->_productRepository->getById($id);
	}
}