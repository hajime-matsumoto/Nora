<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: SocialButton
 */
class SocialButton extends Placeholder
{
	private $_view;
	public function  __construct( $view )
	{
		$this->_view = $view;
	}

	protected function getView( )
	{
		return $this->_view;
	}

	public function __call( $name, $args )
	{
		if( 0 === strpos($name, 'set', 0) && property_exists($this, $new_name = "_".lcfirst(substr($name,3))) )
		{
			$this->$new_name = $args[0];
			return $this;
		}
		echo "$name is not my method";
	}

	/** ダイレクトメソッド */
	public function SocialButton( )
	{
		return $this;
	}

	/**
	 *	Twieet 
			<li class="follow-btn">
				<a href="https://twitter.com/hajime_mat" class="twitter-follow-button" data-link-color="#0069D6" data-show-count="true">Follow @hajime_mat</a>
			</li>
			<li class="tweet-btn">
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://hazime.org" data-count="horizontal" data-via="hajime_mat">Tweet</a>
			</li>
	 */
	public function Twitter( $account = null)
	{
		if(!isset($this['twitter']))
		{
			$this['twitter'] = new SocialButtonTwitter( $this->_view );
		}
		if( $account != null )
		{
			$this['twitter']->setAccount( $account );
		}
		return $this['twitter'];
	}
	public function Tweet( $account = null, $dataURL = null)
	{
		if(!isset($this['tweet']))
		{
			$this['tweet'] = new SocialButtonTweet( $this->_view );
		}
		if( $account != null )
		{
			$this['tweet']->setAccount( $account );
		}
		if( $dataURL != null )
		{
			$this['tweet']->setDataURL( $dataURL );
		}
		return $this['tweet'];
	}
	public function Mixi( $dataServiceKey = null)
	{
		if(!isset($this['mixi']))
		{
			$this['mixi'] = new SocialButtonMixi( $this->_view );
		}
		if( $dataServiceKey != null )
		{
			$this['mixi']->setDataServiceKey( $dataServiceKey );
		}
		return $this['mixi'];
	}
}

class SocialButtonTwitter extends SocialButton
{
	protected $_account, $_data_link_color = '#0069D6', $_data_show_count = 'true';

		// <a href="https://twitter.com/hajime_mat" class="twitter-follow-button" data-link-color="#0069D6" data-show-count="true">Follow @hajime_mat</a>
	public function __toString( )
	{
		$string = '<a href="https://twitter.com/'.$this->_account.'"';
		$string.= ' class="twitter-follow-button"';
		$string.= ' data-link-color="'.$this->_data_link_color.'"';
		$string.= ' data-show-count="'.$this->_data_show_count.'">';
		$string.= 'Follow @'.$this->_account;
		$string.= '</a>';
		return $string;
	}
}

class SocialButtonTweet extends SocialButton
{
	protected $_account, $_dataURL, $_dataCount = 'horizontal';

		// <a href="https://twitter.com/hajime_mat" class="twitter-follow-button" data-link-color="#0069D6" data-show-count="true">Follow @hajime_mat</a>
			//<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://hazime.org" data-count="horizontal" data-via="hajime_mat">Tweet</a>
	public function __toString( )
	{
		$string = '<a href="https://twitter.com/share"';
		$string.= ' class="twitter-share-button"';
		$string.= ' data-url="'.$this->_dataURL.'"';
		$string.= ' data-count="'.$this->_dataCount.'"';
		$string.= ' data-via="'.$this->_account.'"';
		$string.= '>';
		$string.= 'Tweet';
		$string.= '</a>';
		return $string;
	}
	

}


class SocialButtonMixi extends SocialButton
{
	protected $_dataPluginsType='mixi-favorite';
	protected $_dataServiceKey;
	protected $_dataSize='medium';
	protected $_dataHref='';
	protected $_dataShowFaces='false';
	protected $_dataShowCount='true';
	protected $_dataShowComment='true';
	protected $_dataWidth='';

	public function __toString( )
	{
		// Scriptを追加する
		$string = '<div';
		$string.= ' data-plugins-type="'.$this->_dataPluginsType.'"';
		$string.= ' data-service-key="'.$this->_dataServiceKey.'"';
		$string.= ' data-size="'.$this->_dataSize.'"';
		$string.= ' data-href="'.$this->_dataHref.'"';
		$string.= ' data-show-faces="'.$this->_dataShowFaces.'"';
		$string.= ' data-show-count="'.$this->_dataShowCount.'"';
		$string.= ' data-show-comment="'.$this->_dataShowComment.'"';
		$string.= ' data-width="'.$this->_dataWidth.'"';
		$string.= '></div>';
		$this->getView()->footScript('(function(d) {var s = d.createElement(\'script\'); s.type = \'text/javascript\'; s.async = true;s.src = \'//static.mixi.jp/js/plugins.js#lang=ja\';d.getElementsByTagName(\'head\')[0].appendChild(s);})(document);');
		return $string;
	}

}
