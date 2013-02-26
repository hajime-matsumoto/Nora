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

	protected $_messageType = '';
	protected $_message = '';

	private $_actions = 'Nora\Html\Form\Element\Actions';
	private $_hidden_datas = array();

	public function __construct( $id )
	{
		$this->setId($id);
		$this->addHidden('__signe', $this->signe());
	}

	public function signe( )
	{
		return md5($this->getId());
	}

	public function addHidden( $key, $value )
	{
		$this->_hidden_datas[$key] = $value;
		return $this;
	}

	public function getHiddenDatas( )
	{
		return $this->_hidden_datas;
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

	public function success( $message )
	{
		$this->message('success', $message );
		return $this;
	}

	public function message( $type, $message )
	{
		$this->_messageType = $type;
		$this->_message = $message;
		return $this;
	}
}
