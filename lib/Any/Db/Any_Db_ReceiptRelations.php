<?php

class Any_Db_ReceiptRelations extends Any_Db_Db{
	protected function __construct() {
		parent::__construct("w9_receipt_relations");
	}
    public function getInstance(){
        static $instance = null;
        if($instance === null){
            $instance = new self();
        }
        return $instance;
    }

	public static function createTable(){
		global $wpdb;
		$table = $wpdb->prefix . 'w9_receipt_relations';
		$sql = "
CREATE TABLE IF NOT EXISTS `{$table}` (
  `receit_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`receit_id`,`order_id`),
  KEY `order_id` (`order_id`),
  KEY `receit_id` (`receit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		return $wpdb->query($sql);
	}
	public static function deleteTable(){
		global $wpdb;
		$table = $wpdb->prefix . 'w9_receipt_relations';
		$sql = "DROP TABLE {$table};";
		return $wpdb->query($sql);
	}
	
}






