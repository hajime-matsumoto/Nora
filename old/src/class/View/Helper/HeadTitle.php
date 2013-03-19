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
 * タイトルヘルパー
 */
class HeadTitle extends Placeholder
{
	public function __construct( )
	{
		$this->setPrefix('<title>');
		$this->setPostfix('</title>'.PHP_EOL);
		$this->setSeparator('|');
	}

	protected function _headTitle( $title = null )
	{
		if( $title == null ) return;

		$this->append( $title );
	}
}

