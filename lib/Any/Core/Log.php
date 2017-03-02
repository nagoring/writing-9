<?php 
namespace Any\Core;

class Log{
	public static function write($filename, $msg){
		$filepath = __ANY_APP_PATH__ . '/tmp/log/' . $filename;
		$fp = fopen($filepath, 'a');
		fputs($fp, $msg . PHP_EOL);
		fclose($fp);
	}
}