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
 * リクエスト機能
 */
trait RequestTrait
{
    use General\ParamHolderTrait;

    /**
     * モジュール名を取得
     */
    public function getModuleName( $default = null)
    {
        return $this->getParam('module_name', $default);
    }

    /**
     * コントロール名を取得
     */
    public function getControllerName( $default = null)
    {
        return $this->getParam('controller_name', $default);
    }

    /**
     * アクション名を取得
     */
    public function getActionName( $default = null)
    {
        return $this->getParam('action_name', $default);
    }

    /**
     * モジュール名を設定
     */
    public function setModuleName( $value )
    {
        $this->setParam('module_name', $value );
        return $this;
    }

    /**
     * コントロール名を設定
     */
    public function setControllerName( $value )
    {
        $this->setParam('controller_name', $value );
        return $this;
    }

    /**
     * アクション名を設定
     */
    public function setActionName( $value )
    {
        $this->setParam('action_name', $value );
        return $this;
    }

    public function setVars( $datas )
    {
        foreach( $datas as $k=>$v )
        {
            $this[$k] = $v;
        }
    }


}
