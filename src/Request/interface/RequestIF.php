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
namespace Nora\Request;

use Nora\General;

/**
 * リクエストインターフェイス
 */
interface RequestIF extends General\ParamHolderIF
{
    /**
     * モジュール名を取得
     */
    public function getModuleName( $default = null);

    /**
     * コントロール名を取得
     */
    public function getControllerName( $default = null);

    /**
     * アクション名を取得
     */
    public function getActionName( $default = null);

    /**
     * モジュール名を設定
     */
    public function setModuleName( $value );

    /**
     * コントロール名を設定
     */
    public function setControllerName( $value );

    /**
     * アクション名を設定
     */
    public function setActionName( $value );
}
