<?php
namespace Nora\View\Helper\Social\Twitter;

use Nora\Helper;
use Nora\Collection;
/**
 * ヘルパー: Tweet
 */
class Tweet implements Helper\HelperObjectIF
{
	use Helper\HelperObject;
	use Collection\AutoPropSet;

	protected $_account, $_dataURL, $_dataCount = 'horizontal',$_label='Tweet';
	protected $_format =
		'<a href="https://twitter.com/share" class="twitter-share-button" data-url=":dataURL" data-count=":dataCount" data-via=":account">:label</a>';

	public function __toString( )
	{
		return $this->autoPropFormat( $this->_format );
	}

	public function Tweet( $account = null)
	{
		if( $account !=  null )
		{
			$this->setAccount( $account );
		}
		return $this;
	}
}
