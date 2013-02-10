<?php
/*
 * のらリソース
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace NoraResource;
use Nora;

/**
 * アスタリスク接続リソース
 */
class Asterisk implements Nora\Bootstrap\ResourceIF
{
	Use Nora\Core\AutoConfig;

	private $_host,$_port,$_username,$_secret;

	public function factory( )
	{
		return new \Nora\Asterisk\Asterisk( $this->_host, $this->_port, $this->_username, $this->_secret );
	}

	/** 
	 * ホスト名 
	 *
	 * @param string
	 */
	public function configHost( $host )
	{
		$this->_host = $host;
	}

	/**
	 * ポート番号
	 *  
	 * @param int
	 */
	public function configPort( $port )
	{
		$this->_port = $port;
	}

	/**
	 * ユーザー名
	 *
	 * @param string
	 */
	public function configUsername( $username )
	{
		$this->_username = $username;
	}

	/**
	 * パスワード 
	 *
	 * @param string
	 */
	public function configSecret( $secret )
	{
		$this->_secret = $secret;
	}
}
