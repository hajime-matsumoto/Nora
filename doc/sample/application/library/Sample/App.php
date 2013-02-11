<?php
namespace Sample;

use Nora\DI\Component;
use Nora\DI\Containable;

class App extends Component
{
	use Containable;

	private $_bootstrapper;

	public function configBootstrapper( $bs )
	{
		$this->addComponent('bootstrap', $bs);
		$this->addComponent('db', $bs->db);
		$this->addComponent('asterisk', $bs->asterisk);
	}

	public function callHistory( )
	{
		$result = $this->db->query('SELECT * FROM cdr ORDER BY calldate DESC LIMIT 10');
		return $result;
	}

	public function factory( )
	{
		return $this;
	}
}
