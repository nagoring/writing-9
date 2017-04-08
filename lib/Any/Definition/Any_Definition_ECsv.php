<?php

class Any_Definition_EStatus{
    public static $NOT_PAYMENT = 0;
    public static $CREATING_ARTICLES = 10;
    public static $DONE = 20;
    public static function text($status){
        static $tbl = array(
            0 => '未入金',
            10 => '記事作成中',
            20 => '完了',
        );
        return any_safe($tbl, $status, '未入金');
    }
    public static function submitText($status){
        static $tbl = array(
            0 => '発注する',
            10 => '記事作成中',
            20 => '完了',
        );
        return any_safe($tbl, $status, '発注する');
    }
}
