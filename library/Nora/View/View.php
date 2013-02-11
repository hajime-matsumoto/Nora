<?php
namespace Nora\View;

//use Nora\Container\Container;

/**
 * ヘルパー構造を持ったView
 */
class View extends Base
{
	public function displayScript( $script_file, $type = 'script' )
	{

		$file = $this->searchFile( $script_file, 'script' );
		$this->display( file_get_contents( $file ), $this->_view_params );
	}

}














