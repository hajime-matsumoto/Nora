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
 * メタヘルパー
 */
class HeadMeta extends Placeholder
{
	public function __construct( )
	{
		$this->placeholder('charset')->setFormat('<meta charset="%s">'.PHP_EOL);
		$this->placeholder('http-equiv')->setFormat('<meta http-equiv="%s" content="%s">'.PHP_EOL);
		$this->placeholder('name')->setFormat('<meta name="%s" content="%s">'.PHP_EOL);
		$this->placeholder('property')->setFormat('<meta property="%s" content="%s">'.PHP_EOL);
		$this->placeholder('og')->setFormat('<meta property="og:%s" content="%s">'.PHP_EOL);
		$this->placeholder('twitter')->setFormat('<meta name="twitter:%s" content="%s">'.PHP_EOL);
		$this->setFormat("%s".PHP_EOL);
	}

	protected function _headMeta( $name = null, $content = null)
	{
		if( $name == null ) return;
		$this->name($name,$content);
	}

	protected function _charset( $val )
	{
		$this->placeholder('charset')->offsetSet('charset', $val);
	}

	protected function _name( $name, $content )
	{
		$this->placeholder('name')->offsetSet( $name, func_get_args());
	}

	protected function _httpEquiv( $name, $content )
	{
		$this->placeholder('http-equiv')->offsetSet( $name, func_get_args());
	}

	protected function _property( $name, $content )
	{
		$this->placeholder('property')->append( $name, $content );
    }

    protected function _og( $name, $content )
    {
        $this->placeholder('og')->offsetSet($name, func_get_args());
    }

    protected function _twitter( $name, $content )
    {
        $this->placeholder('twitter')->offsetSet($name, func_get_args());
    }
}
