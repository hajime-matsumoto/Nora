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
 * レスポンス機能
 */
trait ResponseTrait
{
    use General\ParamHolderTrait;

    private $_is_cap_end = true;

    /**
     * ステータスコードをセットする
     */
    public function setStatus( $num )
    {
        $this->setParam('status', $num );
    }

    /**
     * ステータスコードを取得する
     */
    public function getStatus( )
    {
        return $this->getParam('status');
    }

    /**
     * 出力バッファをキャプチャする
     */
    public function capStart( )
    {
        $this->_is_cap_end = false;
        ob_start();
    }

    /**
     * 出力バッファのキャプチャを終了する
     */
    public function capEnd( )
    {
        $this->_is_cap_end = true;
        $this['contents'] = ob_get_clean();
    }

    /**
     * 出力バッファのキャプチャ中か
     */
    public function isCapEnd( )
    {
        return $this->_is_cap_end;
    }
}
