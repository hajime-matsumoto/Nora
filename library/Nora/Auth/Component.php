<?php
namespace Nora\Auth;
use Nora\DI;

/**
 * 認証コンポーネント
 */
class Component implements DI\ComponentObjectIF
{
	use DI\ComponentObject;

	private $_type = 'file';
	private $_method_config = array();

	public function init( )
	{

	}

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
