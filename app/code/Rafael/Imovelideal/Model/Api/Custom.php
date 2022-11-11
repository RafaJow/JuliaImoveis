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
        $response = array('success' => false);
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
                $arrayProducts[$key]['name']        = $product->getName();
                $arrayProducts[$key]['id']          = $product->getId();
                $arrayProducts[$key]['sku']         = $product->getSku();
                $arrayProducts[$key]['preco']       = $product->getPrice();
                $arrayProducts[$key]['cidade']      = $product->getAttributeText('cidade');
                $arrayProducts[$key]['bairro']      = $product->getAttributeText('bairro');
                $arrayProducts[$key]['num_quartos'] = $product->getAttributeText('numero_de_quartos');
                $arrayProducts[$key]['patio']       = $product->getAttributeText('possui_patio');
                $arrayProducts[$key]['geminado']    = $product->getAttributeText('geminado');
                $arrayProducts[$key]['negocio']     = $negocio;
                $arrayProducts[$key]['tipo_imovel'] = $tipo_imovel;
            }  

            // $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/imovel_api.log');
            // $logger = new \Zend_Log();
            // $logger->addWriter($writer);
            // $logger->info(json_encode($arrayProducts, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE));

            $response = $arrayProducts;
            
            // $response = array('success'=>true, 'store'=>'store-teste', 'teste'=>'teste');

        } catch (\Exception $e) {
            $response = array('success' => false, 'message' => $e->getMessage());
            $this->logger->info($e->getMessage());
        }
        return [$response]; 
    }

}