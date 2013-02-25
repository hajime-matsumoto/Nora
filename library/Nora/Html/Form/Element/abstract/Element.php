<?php
/*
 * のらライブラリ
 *---------------------- 
 * 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Html\Form\Element;

use Nora\Html;
use Nora\Collection;
use Nora\Html\Form\Render;

class Element
{
	use Collection\AutoPropSet;

	protected $_label, $_name, $_help;
	private $_attrs = array();
	protected $_renderer = 'Nora\Html\Form\Renderer\Renderer';

	public function __construct( $name = null, $attrs = array(), $props = array())
	{
		if( $name != null )
		{
			$this->setName($name);
		}
		$this->autoPropSetArray( $props );
		$this->setAttrs( $attrs );
	}

	public function setHelp( $help, $props =array(), $attrs=array() )
	{
		$this->_help = new Help( $help, $props, $attrs );
		return $this;
	}
	public function setLabel( $label, $props =array(), $attrs=array() )
	{
		$this->_label = new Label( $label, $props, $attrs );
		return $this;
	}

	public function getRenderer( )
	{
		if(is_string($this->_renderer))
		{
			$rc = new \ReflectionClass($this->_renderer);
			$this->_renderer = $rc->newInstance($this);
		}
		return $this->_renderer;
	}

	public function render( )
	{
		$renderer = $this->getRenderer();
		return $renderer->render( );
	}

	public function getBuiltAttrs()
	{
		return $this->buildAttrs();
	}

	public function setAttr( $name, $value )
	{
		$this->_attrs[$name] = $value;
		return $this;
	}

	public function buildAttrs( )
	{
		$parts = array();
		if(is_array($this->_attrs) )
		{
			foreach( $this->_attrs as $k=>$v )
			{
				if(is_int($k))
				{
					$parts[] =$v;
				}
				else
				{
					$parts[] = sprintf('%s="%s"',$k,$v);
				}
			}
		}
		return empty($parts) ? '': ' '.implode(' ', $parts );
	}
}
