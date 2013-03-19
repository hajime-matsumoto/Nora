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
 * プレイスホルダヘルパー
 */
class Doctype extends Placeholder
{
	public function __construct( )
	{
		$this->setFormat("%s\n");
	}

	protected function _doctype( $value = null )
	{
		if( $value !== null  )
		{
			switch( strtolower($value) )
			{
			case 'html5':
				$this['doctype'] = '<!DOCTYPE html>';
				break;
			default:
				$this['doctype'] = $value;
				break;
			}
		}
	}
}
