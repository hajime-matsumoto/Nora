<?php
namespace Nora\Asterisk;
use Nora\DI;

/**
 * Asteriskコンポーネント
 */
class Component implements DI\ComponentObjectIF
{
	use DI\ComponentObject;

	protected $_host = 'localhost',$_port='5038',$_username,$_secret;

	public function init( )
	{
		// Initialize
		$this->_asterisk = new \Nora\Asterisk\Asterisk( $this->_host, $this->_port, $this->_username, $this->_secret );
	}

	public function factory( )
	{
		return $this->_asterisk;
	}

	/** 
	 * ホスト名 
	 *
	 * @param string
	 */
	public function config( $name, $value )
	{
		if( in_array('_'.$name, array_keys(get_object_vars($this))))
		{
			$this->{'_'.$name} = $value;
		}
	}

}
