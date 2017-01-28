<?php
/**
 * Plugin Name:     Writing 9
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     writing-9
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Writing_9
 */
include_once __DIR__ . '/lib/writing9_common.php';

if ( is_admin() ) {
    
	//メニューの作成
	add_action('admin_menu', 'writing9_add_pages');
	function writing9_add_pages() {
		// トップレベルメニュー追加 ( メニューの一番下に追加される )
		add_menu_page('Writing-9', 'Writing-9', 8, 'writing9_manager', 'func_writing9_admin_page');
	}
	function order(){
	    if(!validate_ordering()){
	        return false;
	    }
	}
	function validate_ordering(){
	    if(!isset($_POST['text_type']) || $_POST['text_type'] === ''){
	        
	    }
	    if(!isset($_POST['number_articles']) || $_POST['number_articles'] === ''){
	        
	    }
	    
	    
	    
	}
	function func_writing9_admin_page() {
	    $view = \Any\Core\View::getInstance();
	    if(isset($_POST['submit']) && $_POST['submit']){
	        any_safe($_POST, 'text_type');
	        order();
	    }
	    $view->render('views/v_writing9_index.php');
// 		$slideShowModel = NSlideShowModel::getInstance();
// 		if(isset($_POST['delete_submit']) && $_POST['delete_submit']){
// 			$index = $_POST['delete_submit'];
// 			$slideShowModel->update([
// 				'comment' => '',
// 				'url' => '',
// 			], ['slideshow_id' => $index]);
// 		}else if(isset($_POST['submit']) && $_POST['submit']){
// 			for($i=1;$i<=SLIDESHOW_NUMBER_MAX;$i++){
// 				$comment = $_POST['media_comment' . $i];
// 				$url = $_POST['media_img' . $i];
// 				$slideShowModel->update([
// 					'comment' => $comment,
// 					'url' => $url,
// 				], ['slideshow_id' => $i]);
// 			}
// 		}
// 		$slideShowData = $slideShowModel->fetchAll();
// 		echo SlideShowViewUtil::load(dirname(__FILE__) . '/views/v_slideshow.php', [
// 			'slideShowData' => $slideShowData
// 		]);
	}
}