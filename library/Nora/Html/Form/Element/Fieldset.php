<?php
namespace Nora\Html\Form\Element;

use Nora\Html\Form;

/**
 * フィールドセット
 */
class Fieldset extends Group
{
	protected $_renderer = 'Nora\Html\Form\Renderer\Fieldset';

	protected $_id;
	protected $_legend;

	public function __construct( $id, $legend )
	{
		$this->_id = $id;
		$this->_legend = $legend;
	}
}


