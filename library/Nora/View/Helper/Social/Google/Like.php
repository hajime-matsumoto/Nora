<?php
namespace Nora\View\Helper\Social\Google;

use Nora\Helper;
use Nora\Collection;
/**
 * ヘルパー: Google Like
 */
class Like implements Helper\HelperObjectIF
{
	use Helper\HelperObject;
	use Collection\AutoPropSet;

	protected $_dataAction='share';
	protected $_dataAnnotation='bubble';
	private $_format = '<div class="g-plus" data-action=":dataAction" data-annotation=":dataAnnotation"></div>';
	private $_js_format = 'window.___gcfg = {lang: \'ja\'};(function() { var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true; po.src = \'https://apis.google.com/js/plusone.js\'; var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s); })();';

	public function __construct( $view )
	{
		$this->_view = $view;
		$this->_view->footScript($this->_js_format);
	}

	public function __toString( )
	{
		return $this->autoPropFormat( $this->_format );
	}

	public function Like( )
	{
		return $this;
	}
}
