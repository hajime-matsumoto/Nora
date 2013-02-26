<?php
namespace Nora\Html\Form\Element;

use Nora\Collection;

/**
 * ヘルプライン
 */
class Help
{
	use Collection\AutoPropSet;
	use Renderable;

	protected $_help;
	protected $_renderType = 'help';

	private $_renderer = 'Nora\Html\Form\Renderer\Help';

	public function __construct( $help = null)
	{
		if( $help != null )
		{
			$this->setHelp($help);
		}
	}

	public function isEnabled( )
	{
		return $this->_help ? true: false;
	}
}
