<?php
namespace Nora\Mailer;
use ArrayObject;

class Mail extends ArrayObject
{
	private $_encode = 'JIS';

	public function __construct( )
	{
		$this['charset'] = 'iso-2022-jp';
	}

	public function __call( $name, $args)
	{
		if(strpos( $name, 'set', 0) === 0 )
		{
			$this->_set(substr($name,3), $args[0]);
			return $this;
		}
	}

	public function setLanguage( $language )
	{
		mb_language($language);
		mb_internal_encoding("UTF-8");
		return $this;
	}

	public function setEncode( $code )
	{
		$this->_encode = $code;
	}

	private function _set( $name, $value )
	{
		$this[strtolower($name)] = $value;
	}

	public function setTo( $address, $name = null)
	{
		$this['to'][$address] = array($address,$name ? $name: $address);
		$this->addRecipient( $address, $name );
		return $this;
	}

	public function setFrom( $address, $name = null )
	{
		$this['from'] = array($address,$name ? $name: $address);
		return $this;
	}

	public function encodedTo( )
	{
		$list = array();
		foreach( $this['to'] as $to )
		{
			$list[] = sprintf( '%s <%s>', $this->mimeEncode($to[1]),$to[0] );
		}
		return implode(',',$list);
	}

	public function getContentType()
	{
		return 'text/plain; charset='.$this['charset'];
	}

	public function encodedFrom( )
	{
		return sprintf( '%s <%s>', $this->mimeEncode($this['from'][1]),$this['from'][0]);
	}

	public function mimeEncode( $data )
	{
		return  mb_encode_mimeheader( $this->encode($data) );
	}

	public function encode( $data )
	{
		return mb_convert_encoding( $data, $this->_encode);
	}


	public function encodedSubject( )
	{
		return $this->mimeEncode( $this['subject'] );
	}
	public function encodedBody( )
	{
		return $this->encode( $this['body'] );
	}


	public function addRecipient( $address, $name )
	{
		$this['recipients'][$address] = array($address,$name);
		return $this;
	}

	public function getRecipients( )
	{
		$list = array();
		foreach( $this['recipients'] as $recipient )
		{
			$list[] = $recipient[0];
		}
		return $list;
	}
}
