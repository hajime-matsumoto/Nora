<?php
namespace Nora\Auth\Method;

abstract class Method implements MethodIF
{
	private $_options;

	public function __construct( $options )
	{
		$this->_options = $options;
		$this->init( );
	}

	public function getOption( $name, $default = null )
	{
		return isset($this->_options[$name]) ? $this->_options[$name]: $default;
	}
}
