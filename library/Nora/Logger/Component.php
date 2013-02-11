<?php
namespace Nora\Logger;
use Nora\DI;

/**
 * ロガー
 */
class Component extends DI\Component implements DI\ComponentIF
{
	private $_type,$_config,$_PHPErrorHandling = 'off';

	public function configType( $type )
	{
		$this->_type = $type;
	}

	public function configConfig( $config )
	{
		$this->_config = $config;
	}

	public function configPHPErrorHandling( $value )
	{
		$this->_PHPErrorHandling = $value;
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
