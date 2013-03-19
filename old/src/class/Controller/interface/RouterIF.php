<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Controller
 * @package    Router
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Controller;

/**
 * ルーターインターフェイス
 */
interface RouterIF
{
    /**
     * リクエストを設定する
     */
    public function setRequest( RequestIF $request );

    /**
     * ルートを追加する
     */
    public function addRoute( $name, $pattern, $defaults = array() );
}
