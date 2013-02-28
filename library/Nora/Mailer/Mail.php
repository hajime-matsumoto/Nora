<?php
namespace Nora\Mailer;
use ArrayObject;

class Mail extends ArrayObject
{

	// メールヘッダーの初期値を定義
	private $_headers = array(
		'MIME-Version'=>array('value'=>'1.0'),
		'Content-Type'=>array('value'=>'text/plain','options'=>array('charset'=>'utf8')),
		'Content-Transfer-Encoding'=>array('value'=>'base64'),
		'Content-Disposition'=>array('value'=>'inline')
	);

	// メール本文を格納
	private $_body = '';

	// メール送信先リスト
	private $_recipients = array();

	// 送信者アドレス
	private $_from_address = '';

	// メイラー
	private $_mailer;

	/**
	 * メイラーをセットする
	 */
	public function setMailer( $mailer )
	{
		$this->_mailer = $mailer;
		return $this;
	}

	/**
	 * ファイルを解析してメールオブジェクトを作成
	 */
	static public function loadFile( $file )
	{
		return MailParser::file( $file );
	}

	/**
	 * ヘッダーを追加する
	 * 追加時に必要な処理を加える
	 */
	public function addHeader( $key, $value, $options = null )
	{
		$key = ucfirst($key);
		// アドレスに関連するヘッダーの処理
		if( in_array( $key, array('From','To','Cc','Bcc') ) )
		{
			if(preg_match('/<([^>]+)>/',$value,$m))
			{
				$address = $m[1];
			}else{
				$address = $value;
			}
			$address = trim(trim($address),'"');

			// From以外は全て宛先アドレスとして登録
			if( $key != 'From' )
			{
				$this->addRecipient( $address );
			}else{
				// Fromは送信アドレスとして登録
				$this->setFromAddress( $address );
			}
		}

		// Bccはヘッダーに記録しない
		if( $key == 'Bcc')
		{
			return false;
		}

		// 複数宣言可能なもの
		if( in_array( $key, array('To','Cc') ) )
		{
			$this->_headers[$key][] = array('value'=>$value,'options'=>$options);
		}else{
			// 複数宣言出来ないものは上書き
			$this->_headers[$key] = array('value'=>$value,'options'=>$options);
		}
	}

	/**
	 * 本文を追加する
	 */
	public function addBody(  $value, $postfix = "\n" )
	{
		$this->_body .= $value.$postfix;
	}

	/**
	 * ヘッダーをテキスト化
	 */
	public function headerToString( )
	{
		$parts = array();
		foreach( $this->_headers as $k=>$v )
		{
			if( is_string($v) )
			{
				$parts[] = sprintf('%s: %s', $k, $v);
			}elseif( !isset($v['value']) ){
				foreach( $this->_headers[$k] as $kk=>$vv )
				{
					$parts[] = $this->_buildHeader( $k, $vv );
				}
			}else{
				$parts[] = $this->_buildHeader( $k, $v );
			}
		}
		return implode(PHP_EOL,$parts);
	}

	/**
	 * ヘッダーをテキスト化(単体)
	 */
	public function _buildHeader( $type, $parts )
	{
		// プレースホルダーを解決する
		$parts['value'] = $this->_parsePlaceholders( $parts['value'] );

		// 特定のヘッダーはISO-2022-JPする
		if( in_array($type,array('From','To','Cc') ) )
		{
			if( preg_match('/["]{0,1}([^"\\\]+)["]{0,1}\s*<([^>]+)>/', $parts['value'], $m) )
			{
				$parts['value'] = sprintf('%s <%s>', mb_encode_mimeheader($m[1]), $m[2]);
			}
		}elseif( $type == 'Subject' ){
			$parts['value'] = mb_encode_mimeheader($parts['value']);
		}

		$text = sprintf('%s: %s', $type, $parts['value'] );
		if( isset( $parts['options'] ) && is_array($parts['options']) )
		{
			foreach($parts['options'] as $k=>$v)
			{
				$text.= sprintf('; %s="%s"', $k,$v);
			}
		}
		return $text;
	}

	/**
	 * 本文をテキスト化(単体)
	 * エンコード
	 */
	public function bodyToString( )
	{ 
		$text = $this->_body;
		$text = $this->_parsePlaceholders( $text );
		switch( trim($this->_headers['Content-Transfer-Encoding']['value']) )
		{
		case 'base64':
			$text = base64_encode($text);
			break;
		}
		// プレースホルダーを解決する
		return $text;
	}

	/**
	 * プレースホルダーを展開する
	 */
	protected function _parsePlaceholders( $text )
	{
		return $text = preg_replace('/:([a-zA-Z0-9_]+)/e', '$this->_placeholder("\1")', $text );
	}

	/**
	 * プレースホルダー変数を展開する
	 */
	protected function _placeholder( $name )
	{
		if(isset($this[$name]))
		{
			return $this[$name];
		}
		return $name;
	}

	/**
	 * 宛先を追加
	 */
	public function addRecipient( $address )
	{
		$this->_recipients[$address] = $address;
	}

	/**
	 * 宛先を取得(複数)
	 */
	public function getRecipients( )
	{
		return $this->_recipients;
	}

	/**
	 * 送信者アドレスを設定
	 */
	public function setFromAddress( $address )
	{
		$this->_from_address = $address;
	}

	/**
	 * 送信者アドレスを取得
	 */
	public function getFromAddress( )
	{
		return $this->_from_address;
	}

	/**
	 * メールを作成する
	 */
	public function toString( )
	{
		$text = $this->headerToString( );
		$text.= PHP_EOL.PHP_EOL;
		$text.= $this->bodyToString();
		$text.= PHP_EOL;
		return $text;
	}

	/**
	 * メールをキューにする
	 */
	public function toQue( )
	{
		return array('recipients'=>$this->getRecipients(),'from'=>$this->getFromAddress(),'mail'=>$this->toString());
	}

	/**
	 * メールをキューにする
	 */
	public function que( )
	{
		$this->_mailer->sendQue( $this );
	}
}
