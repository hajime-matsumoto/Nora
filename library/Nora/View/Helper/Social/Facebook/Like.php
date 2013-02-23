<?php
namespace Nora\View\Helper\Social\Facebook;

use Nora\Helper;
use Nora\Collection;
/**
 * ヘルパー: FacebookLike
 */
class Like implements Helper\HelperObjectIF
{
	use Helper\HelperObject;
	use Collection\AutoPropSet;

	protected $_appId='share';
	protected $_dataLayout='button_count';
	protected $_dataWidth='450';
	protected $_dataAnnotation='bubble';
	private $_format = '
		<div class="fb-like" data-send="true" data-layout=":dataLayout" data-width=":dataWidth" data-show-faces="true"></div>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=:appId";
fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';

	public function __construct( $view )
	{
		$this->_view = $view;
	}

	public function __toString( )
	{
		return $this->autoPropFormat( $this->_format );
	}

	public function Like( $appId = null)
	{
		if( $appId != null )
		{
			$this->setAppId( $appId );
		}
		return $this;
	}
}
