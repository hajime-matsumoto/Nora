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

class Asterisk implements Nora\Bootstrap\ResourceIF
{
	Use Nora\Core\AutoConfig;

	private $_host,$_port,$_username,$_secret;

	public function factory( )
	{
		return new \Nora\Asterisk\Asterisk( $this->_host, $this->_port, $this->_username, $this->_secret );
	}

	/** ホスト名 */
	public function configHost( $host )
	{
		$this->_host = $host;
	}

	/** ポート番号*/
	public function configPort( $port )
	{
		$this->_port = $port;
	}

	/** ユーザー名 */
	public function configUsername( $username )
	{
		$this->_username = $username;
	}

	/** パスワード */
	public function configSecret( $secret )
	{
		$this->_secret = $secret;
	}
}
