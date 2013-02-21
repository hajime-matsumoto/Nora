<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: HeadScript
 */
class HeadScript extends Placeholder
{
	public function __construct( )
	{
		$this->placeholder('file')->setFormat("<script type=\"%s\" charset=\"%s\" language=\"%s\" src=\"%s\"></script>\n");
		$this->placeholder('code')->setFormat("<script type=\"%s\" charset=\"%s\" language=\"%s\">\n%s\n</script>");
	}

	/** ダイレクトメソッド */
	public function HeadScript( 
		$content      = false,
		$charset      = 'utf-8',
		$language     = 'javascript',
		$type         = 'text/javascript',
		$content_type = 'code',
		$mode         = 'APPEND'
	){
		if( $content !== false )
		{
			$this->placeholder($content_type)->add(array($type,$charset,$language,$content), $mode);
		}
		return $this;
	}

	public function appendFile( $src, $charset='utf-8',$language='javascript', $type= 'text/javascript')
	{
		return $this->HeadScript( $src, $charset, $language, $type, 'file', 'APPEND');
	}

	public function capEnd( )
	{
		$this->HeadScript(ob_get_clean());
	}

}
