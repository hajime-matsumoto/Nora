<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Controller
 * @package    Controller
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */

namespace Nora\Controller;

/**
 * コントローラーインターフェイス
 */
interface ControllerIF
{
	/**
	 * モジュールをセットする
	 */
	public function setModule( $module );

	/**
	 * モジュールを取得する
	 */
    public function getModule( );

    /**
     * 名前をセットする
     */
    public function setName( $name );

    /**
     * アクションを初期化する
     */
    public function init( );

    /**
     * アクションを実行する
     */
    public function run( $action_name, $request = null, $response = null);
}
