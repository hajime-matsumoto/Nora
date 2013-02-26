<?php
namespace Nora\Html\Form;
use Nora\Collection;
use ArrayObject;
use ReflectionClass;

/**
 * Formコンポーネント
 */
class Form  extends Element\Group
{
	use FactorySet;
	use Element\Renderable;

	protected $_renderer = 'Nora\Html\Form\Renderer\Form';
	protected $_action;
	protected	$_method;

	private $_actions = 'Nora\Html\Form\Element\Actions';

	public function __construct( )
	{
	}

	public function getFormat( )
	{
		return '<form method=":method" action=":action" :attributes>';
	}

	/**
	 * アクション
	 */
	public function actions( $act_name = null)
	{
		if( is_string($this->_actions) )
		{
			$rc = new ReflectionClass($this->_actions);
			$this->_actions = $rc->newInstance();
		}
		if( $act_name != null)
		{
			$this->_actions->addButton('submit', $act_name);
		}
		return $this->_actions;
	}
}
