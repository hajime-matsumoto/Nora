<?php
namespace Useful;

use Nora\Core\AutoConfig;

class Jumper
{
	use AutoConfig;

	private $_urls = array();

	public function factory( )
	{
		return $this;
	}

	public function configTest( $value )
	{
		var_Dump($value);
	}

	public function addUrl( $url )
	{
		$this->_urls[] = $url;
	}

	public function getRand( )
	{
		$index = rand( 0, count($this->_urls)  - 1 );
		return $this->_urls[$index];
	}

}
?>
