<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: HeadStyle
 */
class HeadStyle extends Placeholder
{
	public function __construct( )
	{
		$this->placeholder('file')->setFormat('<link rel="stylesheet" media="%s" type="%s" href="%s">'.PHP_EOL);
		$this->placeholder('code')->setFormat("<style media=\"%s\" type=\"%s\">\n%s\n</style>");
	}

	/** ダイレクトメソッド */
	public function HeadStyle( 
		$content      = false,
		$media        = 'screen',
		$type         = 'text/css',
		$content_type = 'code',
		$mode         = 'APPEND'
	){
		if( $content !== false )
		{
			$this->placeholder($content_type)->add(array($media,$type,$content), $mode);
		}
		return $this;
	}

	public function appendFile( $src, $media = 'screen', $type = 'text/css')
	{
		return $this->HeadStyle( $src, $media, $type, 'file', 'APPEND');
	}
}
