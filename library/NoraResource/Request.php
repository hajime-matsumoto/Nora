<?php
/*
 * のらリソース
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace NoraResource;
use Nora;

class Request implements Nora\Bootstrap\ResourceIF
{
	Use Nora\Core\AutoConfig;

	public function configDI( $DI )
	{
		$this->_DI = $DI;
	}

	public function factory( )
	{
		return $this;
	}
}
