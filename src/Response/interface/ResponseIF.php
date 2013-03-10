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
namespace Nora\Response;

use Nora\General;

/**
 * レスポンスインターフェイス
 */
interface ResponseIF extends General\ParamHolderIF
{
    /**
     * ステータスコードをセットする
     */
    public function setStatus( $num );

    /**
     * ステータスコードを取得する
     */
    public function getStatus( );

    /**
     * 出力バッファをキャプチャする
     */
    public function capStart( );

    /**
     * 出力バッファのキャプチャを終了する
     */
    public function capEnd( );

    /**
     * 出力バッファのキャプチャ中か
     */
    public function isCapEnd( );
}
