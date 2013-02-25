<?php
namespace Nora\Form\Element;

use ArrayObject,ReflectionClass;

class Group extends ArrayObject implements ElementObjectIF
{
	use ElementObject {
		__construct as ElementObject__construct;
	}
	private $_level;

	public function __construct( $name, $label, $level = 0, $attributes = array())
	{
		$this->ElementObject__construct( $name, $label, $attributes );
		$this->setLevel($level);
	}

	public function setLevel( $level )
	{
		$this->_level = $level;
	}

	public function getLevel( )
	{
		return $this->_level;
	}


	public function addElement( $type, $name, $label )
	{
		$rc = new ReflectionClass(__NAMESPACE__.'\\'.ucfirst($type));
		$this[$name] = $rc->newInstanceArgs( array_slice(func_get_args(),1) );
		return $this;
	}

	/**
	 * アクショングループを作成する
	 */
	public function addActions( $name, $label = null, $attributes = array())
	{
		return $this->addElement( 'Actions', $name, $label, $this->getLevel() + 1 , $attributes);
	}


	/**
	 * 新しくグループを作成する
	 */
	public function addGroup( $name, $label = null, $attributes = array())
	{
		return $this->addElement( 'Group', $name, $label, $this->getLevel() + 1 , $attributes);
	}

	/**
	 * 新しくテキストを作成する
	 */
	public function addText( $name, $label = null, $attributes = array() )
	{
		return $this->addElement( 'Text', $name, $label, $attributes);
	}

	/**
	 * 新しくEmailテキストを作成する
	 */
	public function addEmail( $name, $label = null, $attributes = array() )
	{
		return $this->addElement( 'Email', $name, $label, $attributes);
	}

	/**
	 * チェックボックスを作成する
	 */
	public function addCheckbox( $name, $label = null, $attributes = array() )
	{
		return $this->addElement( 'Checkbox', $name, $label, $attributes);
	}

	public function addTextarea( $name, $label = null, $attributes = array() )
	{
		return $this->addElement( 'Textarea', $name, $label, $attributes);
	}


	/**
	 * ボタンを作成する
	 */
	public function addButton( $name, $label = null, $attributes = array() )
	{
		return $this->addElement( 'Button', $name, $label, $attributes );
	}

	/**
	 * 送信ボタンを作成する
	 */
	public function addSubmit( $name, $label = null, $attributes = array() )
	{
		return $this->addElement( 'Submit', $name, $label, $attributes );
	}

	public function __get( $name )
	{
		return $this[$name];
	}

	public function search( )
	{
		$result = $names = array();
		if(func_num_args()>0)
		{
			foreach( func_get_args() as $v )
			{
				if(is_array($v))
				{
					$names = array_merge($names, $v);
				}else{
					$names[] = $v;
				}
			}
		}
		foreach( $this as $v )
		{
			if( $v instanceof Group )
			{
				$result = array_merge( $result, $v->search( $names)->getResult() );
			}
			if( empty($names) || in_array($v->getName(), $names ) )
			{
				$result[] = $v;
			}
		}
		return new SearchResult( $result );
	}
}

class SearchResult
{
	private $_result;

	public function __construct( $result )
	{
		$this->_result = $result;
	}
	public function getResult( )
	{
		return $this->_result;
	}
	public function __call( $name, $args )
	{
		foreach($this->_result as $v )
		{
			call_user_func_array( array($v,$name), $args );
		}
		return $this;
	}
}

