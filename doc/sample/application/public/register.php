<?php 
use Nora\Core\Nora;
require_once '../header.php'; 

// レイアウトの設定
Nora::getInstance( )->bootstrap->view->layout()->set('layout.html')->enable();

// テンプレートを表示
Nora::getInstance( )->bootstrap->view->display('register.html');
?>
