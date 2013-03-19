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
namespace Nora\General\Helper;

/**
 * ヘルパ機能
 */
trait HelperTrait
{
	/**
	 * ヘルパを実行
	 */
	public function invoke( )
	{
		// ダイレクトメソッドを検索
		$class           = get_class($this);
		$pos             = strrpos($class,'\\');
		$class_base_name = substr( $class, $pos + 1 );

		if( !method_exists($this,$class_base_name) ){
			throw new DirectMethodNotDefined( $class_base_name );
		}

		return call_user_func_array( array($this,$class_base_name), func_get_args() );
	}


	/**
	 * ヘルパを実行
	 */
	public function invokeArgs( $args = array() )
	{
		return call_user_func_array(array($this,'invoke'), $args);
    }

    public function __invoke( )
    {
        return $this->invokeArgs(func_get_args());
    }
}

class DirectMethodNotDefined extends \Exception { }
