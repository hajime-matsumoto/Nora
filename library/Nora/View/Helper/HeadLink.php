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
class HeadLink extends Placeholder
{
	public function __construct( )
	{
		$this->setFormat('<link rel="%s" href="%s" media="%s" type="%s" />'.PHP_EOL);
	}

	/** ダイレクトメソッド */
	public function HeadLink( $rel = null, $href = null, $media = null, $type = null, $mode = 'APPEND' )
	{
		if( $rel != null )
		{
			$this->add( array($rel,$href,$media,$type), $mode);
		}
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
}
