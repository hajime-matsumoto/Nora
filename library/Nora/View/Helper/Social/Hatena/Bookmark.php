<?php
namespace Nora\View\Helper\Social\Hatena;

use Nora\Helper;
use Nora\Collection;
/**
 * ヘルパー: HatenaBookmark
 <a id="hb_like" href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="standard" title="このエントリーをはてなブックマークに追加">
 <img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" />
 </a>
 <script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
<script type="text/javascript">document.getElementById("hb_like").href="http://b.hatena.ne.jp/entry/"+location.href</script>
 */
class Bookmark implements Helper\HelperObjectIF
{
	use Helper\HelperObject;
	use Collection\AutoPropSet;

	protected $_dataHatenaBookmarkLayout='share';
	protected $_title='このエントリーをはてなブックマークに追加';
	protected $_dataAnnotation='bubble';
	private $_format = 
		'<a id="hb_like" href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout=":dataHatenaBookmarkLayout" title=":title"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a>';
	private $_js_format = 'document.getElementById("hb_like").href="http://b.hatena.ne.jp/entry/"+location.href';

	public function __construct( $view )
	{
		$this->_view = $view;
		$this->_view->footScript($this->_js_format);
		$this->_view->footScript( )->appendFile("http://b.st-hatena.com/js/bookmark_button.js");
	}

	public function __toString( )
	{
		return $this->autoPropFormat( $this->_format );
	}

	public function Bookmark( )
	{
		return $this;
	}
}
