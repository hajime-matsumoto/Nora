<?php
namespace Nora\Request;

trait RequestObject
{
	public function fetchStartWith( $neadle )
	{
		$result = array();
		foreach($this as $k=>$v)
		{
			if( 0 === strpos($k, $neadle, 0))
			{
				$result[$k] = $v;
			}
		}
		return $result;
	}

	public function fetch( $key, $escape = true )
	{
		$result = array();
		if(is_array($key))
		{
			foreach( $key as $k )
			{
				if(isset($this[$k]))
				{
					$result[$k] = $escape ? $this[$k]: $this->raw($k);
				}
			}
		}
		return $result;
	}

	public function fetchRaw( $key )
	{
		return $this->fetch($key, false);
	}
}


