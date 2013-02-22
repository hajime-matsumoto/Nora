<?php
/*
 * のらライブラリ
 *---------------------- 
 * 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Form\Element;
use ReflectionClass;

trait ElementObject
{
	private $_name;
	private $_label;
	private $_id;
	private $_classes = array();
	private $_value;
	private $_placeholder;
	private $_renderer = 'Nora\Form\Renderer';
	private $_attributes = array();
	private $_help_line;

	public function __construct( $name, $label = null , $attributes = array() )
	{
		$this->_name = $name;
		$this->setAttr('id', $this->_name);
		$this->setAttr('name', $this->_name);

		if( $label != null )
		{
			$this->_label = new Label( $label );
		}
		$this->setAttributes( $attributes );
	}

	public function addHelpLine( $help, $attributes = array() )
	{
		$this->_help_line = new HelpLine( $help, $attributes );
		return $this;
	}

	public function getHelpLine( )
	{
		return $this->_help_line;
	}


	public function getLabel( )
	{
		return $this->_label;
	}
	public function getName()
	{
		return $this->_name;
	}

	public function setRenderer( $renderer )
	{
		$this->_renderer = $renderer;
	}

	public function getRenderer( )
	{
		if(is_string($this->_renderer))
		{
			$rc = new ReflectionClass($this->_renderer);
			$this->_renderer = $rc->newInstance( $this );
		}
		return $this->_renderer;
	}

	public function render( )
	{
		return $this->getRenderer( )->render();
	}

	public function setAttributes( $attributes )
	{
		foreach( $attributes as $k=>$v )
		{
			$this->setAttr( $k, $v );
		}
	}

	public function setAttr( $name, $value )
	{
		if($name == 'class')
		{
			$this->addClass($value);
			return $this;
		}

		$this->_attributes[$name] = $value;
		return $this;
	}

	public function addClass( $class )
	{
		if(func_num_args() > 1 )
		{
			foreach(func_get_args() as $v)
			{
				$this->addClass($v);
			}
			return $this;
		}
		if( strpos($class,' ') )
		{
			foreach( explode( ' ', $class ) as $v )
			{
				$this->addClass( $v);
			}
			return $this;
		}
		$this->_attributes['class'][$class] = $class;
		return $this;
	}


	public function getClasses( )
	{
		return implode(' ', $this->_classes );
	}

	public function getAttributes( )
	{
		$attributes = '';
		foreach( $this->_attributes as $k=>$v )
		{
			if(is_int($k))
			{
				$attributes.= ' '.$v;
			}
			else
			{
				$attributes.= sprintf(' %s="%s"', $k, $this->getAttr($k));
			}
		}
		return $attributes;
	}

	public function getID( )
	{
		return $this->getAttr('id') ? $this->getAttr('id'): $this->getName();
	}


	public function getAttr( $key )
	{
		if( $key == 'class' )
		{
			return isset($this->_attributes[$key]) ? implode(' ', $this->_attributes[$key]): '';
		}
		return isset($this->_attributes[$key]) ? $this->_attributes[$key]: false;
	}

	/*
	public function setValue( $value )
	{
		$this->_value = $value;
	}
	public function getValue() 
	{
		return $this->_value;
	}
	public function setPlaceholder( $placeholder )
	{
		$this->_placeholder = $placeholder;
	}
	public function getPlaceholder() 
	{
		return $this->_placeholder;
	}

	public function setAttributes( $attributes )
	{
		$this->_attributes = $attributes;
	}




	public function init( )
	{
	}

	public function setName( $name )
	{
		$this->_name = $name;
		return $this;
	}

	public function setLabel( $name )
	{
		$this->_label = $name;
		return $this;
	}


	public function getID( )
	{
		return $this->_id ? $this->_id: $this->getName();
	}

	public function getLabel()
	{
		return $this->_label;
	}

	public function getName()
	{
		return $this->_name;
	}

	 */
}
