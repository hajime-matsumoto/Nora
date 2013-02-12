<?php
namespace Nora\Auth;
use Nora\DI;

/**
 * SESSIONコンポーネント
 */
class Component extends DI\Component implements DI\ComponentIF
{
	private $_type = 'file';
	private $_method_config = array();

	public function factory( )
	{
		// メソッド
		$rc     = new \ReflectionClass( __NAMESPACE__.'\Method\\'.ucfirst($this->_type) );
		$method = $rc->newInstance( $this->_method_config );

		$authManager = new Manager();
		$authManager->setMethod( $method );
		return $authManager;
	}

	public function configType( $value )
	{
		$this->_type;
	}

	public function configMethodConfig( $value )
	{
		$this->_method_config = $value;
	}
}
