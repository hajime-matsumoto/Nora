<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   View
 * @package    Helper
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\View\Helper;

/**
 * ヘルパー: HeadScript
 */
class HeadScript extends Placeholder
{
	public function __construct( )
    {
        $this->setPostfix(PHP_EOL);
		$this->placeholder('file')->setFormat("<script type=\"%s\" charset=\"%s\" language=\"%s\" src=\"%s\"></script>\n");
		$this->placeholder('code')->setFormat("<script type=\"%s\" charset=\"%s\" language=\"%s\">\n%s\n</script>");
	}

	protected function _capEnd( )
	{
		$this->appendCode( ob_get_clean() );
	}

	protected function _headScript( )
	{
	}

	public function appendFile( $src, $charset='utf-8',$language='javascript', $type= 'text/javascript')
	{
		return $this->placeholder('file')->append( $type, $charset, $language, $src);
	}

	public function appendCode( $code, $charset='utf-8',$language='javascript', $type= 'text/javascript')
	{
		return $this->placeholder('code')->append( $type, $charset, $language, $code);
	}
}
