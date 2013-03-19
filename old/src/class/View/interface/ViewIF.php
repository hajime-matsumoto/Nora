<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   View
 * @package    View
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\View;

use Nora\Base\DI;

/**
 * ビューインターフェイス
 */
interface ViewIF extends DI\ComponentIF
{
    /**
     * テンプレーターをセットする
     *
     * @param mixed class名かオブジェクト
     */
    public function setTemplator( $templator_class );

    /**
     * テンプレーターを取得する
     */
    public function getTemplator( );

    /**
     * View用のレスポンスを作成
     */
    public function createResponse( );

    /**
     * レスポンスをレンダリング
     */
    public function renderResponse( ResponseIF $response );
}
