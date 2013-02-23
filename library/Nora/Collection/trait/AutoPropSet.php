<?php
namespace Nora\Collection;

trait AutoPropSet
{
	public function __call( $name, $args )
	{
		if( 0 === strpos($name, 'set', 0) && property_exists($this, $new_name = "_".lcfirst(substr($name,3))) )
		{
			$this->$new_name = $args[0];
			return $this;
		}
		throw new Exception('Cant Call Method '.$name.' ');
	}

	public function autoPropFormat( $format )
	{
		return preg_replace('/:([a-zA-Z0-9]+)/e','$this->autoPropGet("\1")', $format);
	}

	public function autoPropGet( $name )
	{
		$real_name = "_".lcfirst($name);
		if( property_exists( $this, $real_name ) )
		{
			return $this->$real_name;
		}
		return $name;
	}
}
