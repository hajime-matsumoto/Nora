<?php
namespace Nora\Helper;

trait HelperBrokerHolder
{
	private $_helper_broker;

	public function setHelperBroker( $broker )
	{
		$this->_helper_broker = $broker;
	}

	public function getHelperBroker( )
	{
		return $this->_helper_broker;
	}

	/** ヘルパーのショートハンド */
	public function __get($name)
	{
		return $this->getHelperBroker()->helper( $name );
	}

	/** ヘルパーのショートハンド */
	public function __call( $name, $args )
	{
		return $this->getHelperBroker()->helperCall( $name, $args );
	}
}
