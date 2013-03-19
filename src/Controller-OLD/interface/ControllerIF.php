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

use Nora\General;
use Nora\Response;
use Nora\Request;

/**
 * コントローラインターフェイス
 */
interface ControllerIF extends General\ParamHolderIF,General\Helper\BrokerOwnerIF
{
    /**
     * レスポンスを設定する
     */
    public function setResponse( $responce );

    /**
     * リクエストを設定する
     */
    public function setRequest( $request );

    /**
     * レスポンスを取得する
     */
    public function getResponse();

    /**
     * リクエストを取得する
     */
    public function getRequest();

    /**
     * アクションを実行する
     */
    public function runAction( $name, Response\ResponseIF $response = null, Request\RequestIF $request = null);
}
