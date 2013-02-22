<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Network;

use Nora\Logger\Logging;


/**
 * ソケット
 */
class Socket
{
	private $_host,$_port;
	private $_socket;

	use Logging;

	public function __construct( $host, $port )
	{
		$this->_host = $host;
		$this->_port = $port;
	}

	/** コネクションを接続 */
	public function connect( )
	{
		$this->_socket = fsockopen($this->_host,$this->_port,$this->_errno, $this->_errstr, 1);
		if(!$this->_socket){
			throw new SocketException( 'Cant Connect' );
		}
		$this->debug( 'Connected: %s:%s', $this->_host, $this->_port );
		return true;
	}

	/** コネクションを切断 */
	public function disconnect( )
	{
		fclose($this->_socket);
	}

	/** １行読み込む */
	public function readLine( )
	{
		if(feof($this->_socket)){
			return false;
		}
		$line = fgets($this->_socket);
		$this->debug( 'Resp:'.$line );
		return $line;
	}

	/** １行書き込む */
	public function writeLine( $text = null )
	{
		if(func_num_args() > 1 )
		{
			return $this->writeLine(vsprintf($text,array_slice(func_get_args(),1)));
		}
		$this->debug( 'Sent: %s', trim($text)."\r\n");
		fputs( $this->_socket, trim($text)."\r\n");
	}

	/** 全てのレスポンスを読み出す */
	public function getResponse( )
	{
		$resp = "";
		while($line = $this->readLine())
		{
			$resp.=$line;
		}
		return $resp;
	}

	/** レスポンスを読み出す */
	public function parseResponse( $expect )
	{
		$response="";
		while(substr($response,3,1) != " "){
			if( !$response = $this->readLine( ) )
			{
				$this->error("サーバーからのレスポンスコードを取得出来ませんでした。");
			}
		}
		if(!(substr($response,0,3) == $expect)){
			$this->error("送信出来ませんでした。SMTPサーバーから次のエラーコードが報告されています。".$response);
		}
		return $response;
	}


}

class SocketException extends \Exception { }
