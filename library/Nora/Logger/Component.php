<?php
namespace Nora\Logger;
use Nora\DI;

/**
 * ロガー
 */
class Component implements DI\ComponentObjectIF
{
	private $_type,$_config,$_PHPErrorHandling = 'off';

	use DI\ComponentObject;

	public function config($name, $value )
	{
		// Private で設定されているものを受け付ける
		if( in_array( '_'.$name, get_object_vars($this) ) )
		{
			$this->{"_".$name} = $value;
		}
	}

	public function init( )
	{
	}

	public function factory( )
	{
		if( $this->_type == false )
		{
			$logger = new Logger();
		}else{
			$logger = Logger::factory( $this->_type, $this->_config );
		}
		if( $this->_PHPErrorHandling == 'on' )
		{
			$logger->register( );
		}
		return $logger;
	}
}
