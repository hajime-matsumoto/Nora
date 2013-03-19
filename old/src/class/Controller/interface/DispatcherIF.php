<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Controller
 * @package    Dispatcher
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Controller;

use Nora\Base\DI;

/**
 * コントローラーディスパッチャ
 */
interface DispatcherIF
{
    /**
     * フロントを設定
     */
    public function setFront( $front );


    /**
     * リクエストをセット
     */
    public function setRequest( $request );

    /**
     * レスポンスをセット
     */
    public function setResponse( $response );

    /**
     * リクエストを取得
     */
    public function getRequest( );

    /**
     * レスポンスを取得
     */
    public function getResponse( );

    /**
     * 起動
     */
    public function dispatch( $request=null, $response=null);
}
