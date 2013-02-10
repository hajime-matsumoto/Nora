<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Request;

/**
 * リクエスト
 */
class Web extends Request
{
	public function __construct( )
	{
		// POSTデータ取り込み
		$this->setData($_POST);
		// GETデータ取り込み
		$this->setData($_GET);
	}

	public function isPost( )
	{
		return 'post' == strtolower($_SERVER['REQUEST_METHOD']) ? true: false;
	}

	public function isGet( )
	{
		return 'get' == strtolower($_SERVER['REQUEST_METHOD']) ? true: false;
	}
}
