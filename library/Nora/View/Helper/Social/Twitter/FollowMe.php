<?php
namespace Nora\View\Helper\Social\Twitter;

use Nora\Helper;
use Nora\Collection;
/**
 * ヘルパー: FollowMe
 */
class FollowMe implements Helper\HelperObjectIF
{
	use Helper\HelperObject;
	use Collection\AutoPropSet;

	protected $_account, $_dataLinkColor = '#0069D6', $_dataShowCount = 'true', $_label = 'Follow @';
	protected $_format =
		'<a href="https://twitter.com/:account" class="twitter-follow-button" data-link-color=":dataLinkColor" ata-show-count=":dataShowCount">:label:account</a>';

	public function __construct( $view )
	{
		$view->footScript('!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");');
	}


	public function __toString( )
	{
		return $this->autoPropFormat( $this->_format );
	}

	public function FollowMe( $account = null)
	{
		if( $account !=  null )
		{
			$this->setAccount( $account );
		}
		return $this;
	}
}
