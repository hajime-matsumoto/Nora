<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Controller
 * @package    Response
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Controller;

/**
 * レスポンス機能
 */
trait ResponseTrait
{
    /**
     * ステータスをセットする
     */
    public function setStatus( $status )
    {
        $this->_status = $status;
    }
}
