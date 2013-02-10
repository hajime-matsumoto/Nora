<?php
namespace Sample;

use Nora\Core\AutoConfig;

class App
{
	use AutoConfig;

	private $_urls = array();

	private $_db;
	private $_bootstrapper;

	public function configBootstrapper( $bs )
	{
		$this->_bootstrapper = $bs;
		$this->_db = $bs->bootstrap('db');
		$this->_asterisk = $bs->bootstrap('asterisk');
	}

	public function callHistory( )
	{
		$result = $this->_db->query('SELECT * FROM cdr ORDER BY calldate DESC LIMIT 10');
		return $result;
	}

	public function factory( )
	{
		return $this;
	}
}
