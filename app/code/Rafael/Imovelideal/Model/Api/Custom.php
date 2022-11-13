<?php
 
namespace Rafael\Imovelideal\Model\Api;
 
use Psr\Log\LoggerInterface;
 
class Custom
{
    protected $logger;

    /** @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory */
    protected $collectionFactory;

    public function __construct(
        LoggerInterface $logger,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
    )
    {
        $this->logger = $logger;
        $this->collectionFactory = $collectionFactory;
    }
 
    /**
     * @inheritdoc
     */
 
    public function getProductCollection()
    {
        try {
            $productCollection = $this->collectionFactory->create();
            $productCollection->addAttributeToSelect('*');

            foreach ($productCollection as $key => $product){
                $tipo_imovel="";
                $negocio="";
                $categories = $product->getCategoryCollection()->addAttributeToSelect('name');
                foreach($categories as $category)
                { 
                    if($category->getName() != "Vendas" AND $category->getName() != "Locações"){
                        $tipo_imovel = $category->getName();
                    }else{
                        $negocio = $category->getName();
                    }
                }
                $arrayProducts[$key]['name']        = strtolower($product->getName());
                $arrayProducts[$key]['id']          = strtolower($product->getId());
                $arrayProducts[$key]['sku']         = strtolower($product->getSku());
                $arrayProducts[$key]['preco']       = strtolower($product->getPrice());
                $arrayProducts[$key]['cidade']      = strtolower($product->getAttributeText('cidade'));
                $arrayProducts[$key]['bairro']      = strtolower($product->getAttributeText('bairro'));
                $arrayProducts[$key]['num_quartos'] = strtolower($product->getAttributeText('numero_de_quartos'));
                $arrayProducts[$key]['patio']       = strtolower($product->getAttributeText('possui_patio'));
                $arrayProducts[$key]['geminado']    = strtolower($product->getAttributeText('geminado'));
                $arrayProducts[$key]['negocio']     = strtolower($negocio);
                $arrayProducts[$key]['tipo_imovel'] = strtolower($tipo_imovel);
                $arrayProducts[$key]['aceita_pet']  = strtolower($product->getAttributeText('aceita_pet'));
            }  

            // $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/imovel_api.log');
            // $logger = new \Zend_Log();
            // $logger->addWriter($writer);
            // $logger->info(json_encode($arrayProducts, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE));            
            // $response = array('success'=>true, 'store'=>'store-teste', 'teste'=>'teste');

        } catch (\Exception $e) {
            $arrayProducts = array('success' => false, 'message' => $e->getMessage());
            $this->logger->info($e->getMessage());
        }
        return $arrayProducts; 
        // $response['produtos'] = $arrayProducts;
        // return json_encode($response);
    }

}