<?php
namespace Any\Definition;

class EStatus{
    public static $NOT_PAYMENT = 0;
    public static $CREATING_ARTICLES = 10;
    public static $DONE = 20;
    public static function text($status){
        static $tbl = [
            0 => '未入金',
            10 => '記事作成中',
            20 => '完了',
        ];
        return any_safe($tbl, $status, '未入金');
    }
}
