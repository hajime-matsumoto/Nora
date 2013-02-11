<?php 
use Nora\Core\Nora;
require_once '../header.php'; 

// 固有の設定
Nora::getInstance( )->bootstrap->view->headTitle('通話予約');

// レイアウトの設定
Nora::getInstance( )->bootstrap->view->layout()->set('layout.html')->enable();

// テンプレートを表示
Nora::getInstance( )->bootstrap->view->display('register.html');
?>
