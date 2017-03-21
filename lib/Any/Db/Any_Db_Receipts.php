<?php
class Any_Db_Receipts extends Any_Db_Db{
	protected function __construct() {
		parent::__construct("w9_receipts");
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
		$table = $wpdb->prefix . 'w9_receipts';
		$sql = "
CREATE TABLE IF NOT EXISTS `{$table}` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mc_gross` int(10) unsigned NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `post_json` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `txn_id` (`txn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		return $wpdb->query($sql);
	}
	public static function deleteTable(){
		global $wpdb;
		$table = $wpdb->prefix . 'w9_receipts';
		$sql = "DROP TABLE {$table};";
		return $wpdb->query($sql);
	}
	
}


