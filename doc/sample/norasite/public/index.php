<?php
require_once dirname(__FILE__).'/../header.php';
use Nora\Core\Nora;
$view = Nora::bootstrap('view');

$view->layout()->set('main.html');
$view->display('index.html');
?>
