<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Asterisk;

use Nora;


/**
 * アスタリスク
 */
class Asterisk
{
	private $_host,$_port,$_username,$_secret;
	private $_version;
	private $_socket;

	public function __construct( $host, $port, $username, $secret )
	{
		$this->_host = $host;
		$this->_port = $port;
		$this->_username = $username;
		$this->_secret = $secret;
	}

	public function connect( )
	{
		$this->_socket = new Nora\Network\Socket( $this->_host, $this->_port );
		$this->_socket->connect( );
		$this->_version = $this->_socket->readline();
	}

	public function getAsteriskVersion( )
	{
		return $this->_version;
	}

	public function login( )
	{
		$this->sendCommand('Login',array('Username'=>$this->_username, 'Secret'=>$this->_secret,'Events'=>'off'));
	}

	public function logoff( )
	{
		$this->sendCommand('Logoff');
	}

	public function command( $name, $params = array())
	{
		$this->connect( );
		$this->login();
		$this->sendCommand($name,$params);
		$this->logoff();
		$resp = $this->_socket->getResponse();
		$this->disconnect();
	}

	public function disconnect( )
	{
		$this->_socket->disconnect();
	}

	public function sendCommand( $name, $params = array() )
	{
		$this->_socket->writeLine('Action: %s',$name);
		foreach( $params as $k=>$v)
		{
			$this->_socket->writeLine('%s: %s', $k,$v);
		}
		$this->_socket->writeLine();
	}

}
