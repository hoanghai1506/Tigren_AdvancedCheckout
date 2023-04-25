<?php

namespace Tigren\AdvancedCheckout\Observer;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Event\ObserverInterface;



class SalesOrderPlaceAfterObserver implements ObserverInterface {
    protected $_resource;
    public function __construct(
        ResourceConnection $resource,
    ) {
        $this->_resource = $resource;
    }

    public function execute( \Magento\Framework\Event\Observer $observer ) {


        try {
        $connection = $this->_resource->getConnection();
        $table = $this->_resource->getTableName('sales_order_address');
        $table2 = $this->_resource->getTableName('customer_entity');
        // get record newest
        $sql = $connection->select()
            ->from($table)
            ->order('entity_id DESC')
            ->limit(1);
        $result = $connection->fetchAll($sql);
        $connection->insert($table2, [
            'firstname' => $result[0]['firstname'],
            'lastname' => $result[0]['lastname'],
            'email' => $result[0]['email'],
            'password_hash' => 'dummy_password'.rand(1,1000),
        ]);
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom2.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info(print_r($result[0]['firstname'], true));
        $logger->info(print_r($result, true));
        } catch ( \Exception $e ) {

        }

    }
}
