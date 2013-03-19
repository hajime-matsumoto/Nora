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
 * ヘルパー: HeadStyle
 */
class HeadStyle extends Placeholder
{
	public function __construct( )
	{
        $this->setPostfix(PHP_EOL);
		$this->placeholder('file')->setFormat('<link rel="stylesheet" media="%s" type="%s" href="%s">'.PHP_EOL);
		$this->placeholder('code')->setFormat("<style media=\"%s\" type=\"%s\">\n%s\n</style>");
    }

    protected function _capEnd( )
    {
        $this->appendCode( ob_get_clean() );
    }

	protected function _headStyle( )
	{
	}

	public function appendFile( $src, $media = 'screen', $type = 'text/css')
	{
		return $this->placeholder('file')->append( $src, $media, $type );
	}

	public function appendCode( $code, $media = 'screen', $type = 'text/css')
	{
		return $this->placeholder('code')->append( $media, $type, $code );
	}
}
