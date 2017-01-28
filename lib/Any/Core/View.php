<?php 
namespace Any\Core;

class View{
    public static function getInstance(){
        static $instance = null;
        if($instance === null){
            $instance = new self();
        }
        return $instance;
    }
	public function render($filepath, $dataHash = array()) {
	    echo $this->load($filepath, $dataHash);
	}
	public function load($filepath, $dataHash = array()) {
		extract($dataHash);
		ob_start();
        $path = any_app_path();
		include $path . '/' . $filepath;
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}

	public function pagination($pages, $paged=1, $range = 2, $link='') {
		$showitems = ($range * 2) + 1;

		if (empty($paged))
			$paged = 1;

		ob_start();
		if (1 != $pages) {
			echo "<div class='pagenavi'>";
//			if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
//				echo "<a href='" . $link . 'paged=1' . "'>◀先頭へ</a>";
			if ($paged != 1)
				echo "<a href='" . $link . 'paged='. ($paged - 1)  . "'>◀前へ</a>";
//			if ($paged > 1 && $showitems < $pages)
//				echo "<span class='pagination_box'><a href='" . $link . 'paged=' . ($paged - 1) . "'>&lsaquo;</a></span>";

			for ($i = 1; $i <= $pages; $i++) {
				if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
					echo ($paged == $i) ? "<a class='current'>" . $i . "</a>" : "<a href='" . $link . 'paged=' . $i . "'>" . $i . "</a>";
				}
			}

			if ($paged != ($pages) )
				echo "<a href='" . $link . 'paged=' . ($paged + 1) . "'>次へ▶</a>";
			echo "</div>\n";
		}
		$html = ob_get_contents();
		ob_clean();
		return $html;
	}
	public function getPaged(){
		if(isset($_GET['paged'])){
			$paged = $_GET['paged'];
		}else{
			$paged = 1;
		}
		return $paged;
	}
	public function getUrl($exarray = array('paged')){
		if(!isset($_GET))return site_url();
		$str = site_url() . '/?';
		foreach($_GET as $key => $value){
			if(in_array($key, $exarray) !== false)continue;

			if(is_array($value)){
				foreach($value as $_value){
					$str .= "{$key}[]={$_value}&";
				}
			}else{
				$str .= "{$key}={$value}&";
			}
		}
		return $str;
	}
}