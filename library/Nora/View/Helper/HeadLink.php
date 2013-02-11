<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: HeadLink
 *
 * $this->headLink()->appendStylesheet('/styles/basic.css')
 * ->headLink(array('rel' => 'icon',
 * 'href' => '/img/favicon.ico'),
 * 'PREPEND')
 * ->prependStylesheet('/styles/moz.css',
 * 'screen',
 * true,
 * array('id' => 'my_stylesheet'));
 */
class HeadLink
{
	use HelperTool;

	private $_link = array();

	/** ダイレクトメソッド */
	public function HeadLink( )
	{
		return $this;
	}

	public function appendStylesheet( $file, $media = 'screen', $type='text/css' )
	{
		$this->addLink( 'StyleSheet',$file, $media, $type, 'APPEND' );
		return $this;
	}

	public function prependStylesheet( $file, $media = 'screen', $type='text/css' )
	{
		$this->addLink( 'StyleSheet',$file, $media, $type, 'PREPEND' );
		return $this;
	}

	public function addLink( $rel, $href, $media, $type, $mode = 'APPEND' )
	{
		$new_link =  array(
			'rel'=>$rel,
			'href'=>$href,
			'media'=>$media,
			'type'=>$type
		);
		if( $mode == 'APPEND' )
		{
			array_push( $this->_link, $new_link );
		}
		else
		{
			array_unshift( $this->_link, $new_link  );
		}

		return $this;
	}

	public function toString( )
	{
		$html = "";
		foreach( $this->_link as $link )
		{
			$html.= '<link';
			foreach( $link as $k=>$v )
			{
				if( !empty( $v ) )
				{
					$html.= sprintf(' %s="%s"', $k,$v);
				}
			}
			$html.= '>'.PHP_EOL;
		}
		return $html;
	}

}
