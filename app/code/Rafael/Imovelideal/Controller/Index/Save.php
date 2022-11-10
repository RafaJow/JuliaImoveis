<?php

namespace Rafael\Imovelideal\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Save extends \Magento\Framework\App\Action\Action
{
    protected $_resource;

    public function __construct(
        Context $context,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->_resource = $resource;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return void
     */
    public function execute()
    {
        try{
            $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/save_imovel.log');
            $logger = new \Zend_Log();
            $logger->addWriter($writer);

            // 1. POST request : Get form data
            $post = (array) $this->getRequest()->getPost();

            if (!empty($post)) {
                // Retrieve your form data

                $negocio    = $post['negocio'];
                $tipo_imovel= $post['tipo'];
                $preco_max  = $post['preco'];
                $cidade     = $post['cidade'];
                $bairro     = $post['bairro'];
                $num_quartos= $post['quartos'];
                $num_pessoas= $post['pessoas'];
                $patio      = $post['patio'];
                $pet        = $post['pet'];
                $nome       = $post['name'];
                $email      = $post['email'];
                $contato    = $post['telephone'];

                $logger->info("negocio $negocio");
                $logger->info("tipo $tipo_imovel");
                $logger->info("preco $preco_max");
                $logger->info("cidade $cidade");
                $logger->info("bairro $bairro");
                $logger->info("quartos $num_quartos");
                $logger->info("pessoas $num_pessoas");
                $logger->info("patio $patio");
                $logger->info("pet $pet");
                $logger->info("name $nome");
                $logger->info("email $email");
                $logger->info("telephone $contato");

                $connection = $this->_resource->getConnection();

                $query = "
                    INSERT INTO busca_imovel (
                        nome,
                        email,
                        contato,
                        negocio,
                        tipo_imovel,
                        preco_max,
                        cidade,
                        bairro,
                        num_quartos,
                        num_pessoas,
                        patio,
                        pet
                    ) 
                    VALUES (
                        '".$nome."',
                        '".$email."',
                        '".$contato."',
                        '".$negocio."',
                        '".$tipo_imovel."',
                        '".$preco_max."',
                        '".$cidade."',
                        '".$bairro."',
                        '".$num_quartos."',
                        '".$num_pessoas."',
                        '".$patio."',
                        '".$pet."'
                    );
                ";

                $connection->query($query); // insert
                // $result = $connection->fetchAll($query); // select

                $this->messageManager->addSuccessMessage('Salvo !');
                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setUrl('/imovelideal/index/index');

                return $resultRedirect;
            }
            // 2. GET request : Render the imovel ideal page 
            $this->_view->loadLayout();
            $this->_view->renderLayout();
        }catch(\Exception $e){
            $logger->info("Exception: ".$e->getMessage());
        }
    }
}