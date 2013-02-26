<?php
namespace Nora\Html\Form\Element;

use Nora\Html\Form;

/**
 * コントロールグループ
 */
class Group extends Element
{
	use Form\FactorySet;

	protected $_renderer = 'Nora\Html\Form\Renderer\Group';
	private $_elements = array();

	public function addElement( $name )
	{
		if( $name instanceof Element )
		{
			foreach( func_get_args() as $element )
			{
				$id = $element->getId();
				$this->_elements[$id] = $element;
			}
		}
		return $this;
	}

	public function getElements( )
	{
		return $this->_elements;
	}

	public function __get($name)
	{
		return isset($this->_elements[$name]) ? $this->_elements[$name]: false;
	}
	
	public function search($q)
	{
		if( $q instanceof \Closure )
		{
			$result = array();
			foreach( $this->_elements as $k=>$v)
			{
				if( $v instanceof Group )
				{
					$result = array_merge($result,$v->search($q)->getArrayCopy());
				}elseif( $q($v) )
				{
					$result[] = $v;
				}
			}
			return new SearchResult($result);
		}
		if( is_array($q) )
		{
			return $this->search(function($e)use($q){ return in_array($e->getId(), $q); });
		}
		if( is_string($q) || func_num_args() > 1 )
		{
			return $this->search( func_get_args() );
		}
	}

	public function each( $cb )
	{
		foreach( $this->_elements as $k=>$v )
		{
			call_user_func($cb, $v);
		}
		return $this;
	}

	public function inputValues( $values )
	{
		$this->each( function($e)use($values){$e->inputValues($values);} );
		return $this;
	}

	/**
	 * バリテーションを実行する
	 */
	public function validate( )
	{
		$result = true;
		foreach( $this->_elements as $e )
		{
			if( false === $validate_result = $e->validate() )
			{
				$this->renderer( )->error();
				$result = false;
			}
		}
		return $result;
	}

	/**
	 * データを取得する
	 */
	public function getValues( )
	{
		$values = array();
		foreach( $this->_elements as $e )
		{
			if( $e instanceof Group )
			{
				$values = array_merge( $values, $e->getValues() );
			}
			elseif( $e->hasName() )
			{
				$values[$e->getName()] = $e->getValue();
			}
		}
		return $values;
	}
}

class SearchResult extends \ArrayObject
{
	public function each( $cb )
	{
		foreach( $this as $k=>$v )
		{
			call_user_func($cb, $v,$k);
		}
		return $this;
	}
}




