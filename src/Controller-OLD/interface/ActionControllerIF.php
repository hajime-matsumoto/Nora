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
namespace Nora\Controller;

use Nora\Response;
use Nora\Request;

/**
 * アクションコントローラインターフェイス
 */
interface ActionControllerIF extends ControllerIF
{
    /**
     * フロントをセットする
     */
    public function setFront( FrontControllerIF $front );
    
    /**
     * アクションを実行する
     */
    public function runAction( $name, Response\ResponseIF $response = null, Request\RequestIF $request = null);
}
