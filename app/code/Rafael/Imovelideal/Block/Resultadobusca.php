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

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => '172.25.109.199:8000/busca-imovel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "email": "'.$email.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);
            $logger->info('responsee: '.$response);
            $logger->info('status: '.json_encode(curl_getinfo($curl, CURLINFO_HTTP_CODE)));
            curl_close($curl);

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