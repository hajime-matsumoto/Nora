<?php
namespace NoraSite;
use Nora;

class Bootstrap extends Nora\Bootstrap\Bootstrapper
{
	protected function _initView( )
	{
		$view = new Nora\View\View( );

		// View ディレクトリの設定
		$view->addViewDir( APP_ROOT.'/view' );

		// サイトの設定
		// ======================================
		$view->headDoctype('html5');
		$view->headMeta()->setCharset('utf-8');
		$view->headMeta()->appendName('keywords','のら,PHP,PHP FRAMEWORK,PHPフレームワーク,フレームワーク');
		$view->headMeta()->appendName('description','のらフレームワークエンジンの紹介サイト');
		$view->headTitle('のらサイト');

		// Twitter Bootstrapの読み込み
		// ======================================
		$view->headStyle()->appendFile("assets/css/bootstrap.min.css");
		$view->headStyle()->appendFile("assets/css/bootstrap-responsive.css");
		$view->footScript()->appendFile("https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js");
		$view->footScript()->appendFile("assets/js/bootstrap.min.js");

		// Google Code Prettify
		// ======================================
		$view->headStyle()->appendFile("assets/css/nora-prettify.css");
		$view->footScript()->appendFile("assets/google-code-prettify/prettify.js");
		$view->footScript('$(function(){prettyPrint()});');

		// Github Fork Me
		// ======================================
		$view->GithubForkMe('hajime-matsumoto/nora');
		return $view;
	}

}
