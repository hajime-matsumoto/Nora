<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Config\Parser;


/**
 * パーサー
 *
 * 実装すると
 * $object->helper名()出来る
 */
interface ParserIF
{
	/**
	 * 解析する
	 */
	static public function parse( $name );
}
