<?php
namespace Nora\Collection;

trait AutoPropSet
{
	public function __call( $name, $args )
	{
		if( 0 === strpos($name, 'set', 0) && $this->autoPropRealName( substr($name,3) ) )
		{
			$this->autoPropSet( substr($name, 3), $args[0]);
			return $this;
		}

		if( 0 === strpos($name, 'get', 0) && $this->autoPropRealName( substr($name,3) ) )
		{
			return $this->autoPropGet( substr($name,3) );
		}

		if( 0 === strpos($name, 'has', 0) && $this->autoPropRealName( substr($name,3) ) )
		{
			return $this->autoPropGet( substr($name,3) ) ? true: false;
		}
		throw new Exception('Cant Call Method '.$name.' ');
	}

	public function autoPropFormat( $format )
	{
		return preg_replace('/:([a-zA-Z0-9]+)/e','$this->autoPropGet("\1")', $format);
	}

	public function autoPropRealName( $name )
	{
		if( property_exists($this, $new_name = "_".lcfirst($name)) )
		{
			return $new_name;
		}
		return false;
	}

	public function autoPropSetArray( $array )
	{
		if(is_array($array))
		{
			foreach( $array as $k=>$v )
			{
				$this->autoPropSet( $k, $v );
			}
		}
		return $this;
	}

	public function autoPropSet( $name, $value )
	{
		if( method_exists( $this, $method = 'set'.$name ) )
		{
			return call_user_func( array($this,$method), $value );
		}

		if( $new_name = $this->autoPropRealName( $name ) )
		{
			$this->$new_name = $value;
			return true;
		}
		return false;
	}

	public function autoPropGet( $name )
	{
		if( method_exists( $this, $method = 'get'.$name ) )
		{
			return call_user_func(array($this,$method));
		}
		$real_name = "_".lcfirst($name);
		if( $new_name = $this->autoPropRealName( $name ) )
		{
			return $this->$real_name;
		}
		return $name;
	}
}
