<?php 

class Any_Core_Log{
	public static function write($filename, $msg){
		$date = date('YmdHis');
		$filepath = __ANY_APP_PATH__ . '/tmp/log/' . $filename . '.txt';
		$fp = fopen($filepath, 'a');
		fputs($fp, $date . ':' . $msg . PHP_EOL);
		fclose($fp);
		echo $filepath;
		echo "<br>";
	}
}