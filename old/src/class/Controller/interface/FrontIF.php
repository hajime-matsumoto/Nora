<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Controller
 * @package    Front
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Controller;

use Nora\Base\DI;
use Nora\Module;

/**
 * コントローラー
 */
interface FrontIF extends DI\ComponentIF,Module\BrokerIF
{
    /**
     * リクエストをセット
     */
    public function setRequest( $request );

    /**
     * リクエストを取得
     */
    public function getRequest( );

    /**
     * ルーターをセット
     */
    public function setRouter( $router );

    /**
     * ルーターを取得
     */
    public function getRouter( );

    /**
     * レスポンスをセット
     */
    public function setResponse( $response );

    /**
     * レスポンスを取得
     */
    public function getResponse( );

    /**
     * ディスパッチをセット
     */
    public function setDispatcher( $dispatcher );

    /**
     * ディスパッチを取得
     */
    public function getDispatcher( );

    /**
     * ビューをセット
     */
    public function setViewRenderer( $view_renderer );

    /**
     * ビューを取得
     */
    public function getViewRenderer( );

    /**
     * 起動
     */
    public function dispatch( );
}
