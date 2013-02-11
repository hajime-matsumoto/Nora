<?php
namespace Nora\Bootstrap;
use Nora\DI;

/**
 * ブートストラップコンポーネント
 */
class Component extends DI\Component implements DI\ComponentIF
{
	private $_class = false;
	public function configClass( $value )
	{
		$this->_class = $value;
	}

	public function factory( )
	{
		if( !$this->_class )
		{
			$this->_class = 'Nora\Bootstrap\Bootstrapper';
		}

		$rc = new \ReflectionClass( $this->_class );
		$bootstrapper = $rc->newInstance();
		return $bootstrapper;
	}
}
