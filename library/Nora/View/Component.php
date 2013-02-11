<?php
namespace Nora\View;
use Nora\DI;

/**
 * Viewコンポーネント
 */
class Component extends DI\Component
{
	public function factory( )
	{
		$view = new View();

		return $view;
	}
}
