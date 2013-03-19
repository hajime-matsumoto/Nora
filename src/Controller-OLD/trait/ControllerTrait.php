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
use Nora\Util\Util;
use Nora\Request;
use Nora\Response;
use Nora\Router;

/**
 * コントローラ機能
 */
trait ControllerTrait
{
    use General\ParamHolderTrait;
    use General\Helper\BrokerOwnerTrait;

    private $response = 'Nora\Response\Response';
    private $request  = 'Nora\Request\Request';

    /**
     * レスポンスを設定する
     */
    public function setResponse( $response )
    {
        $this->response = $response;
    }

    /**
     * リクエストを設定する
     */
    public function setRequest( $request )
    {
        $this->request = $request;
    }

    /**
     * レスポンスを取得する
     */
    public function getResponse()
    {
        return $this->response = Util::helper('object')->newInstanceFromString($this->response);
    }

    /**
     * リクエストを取得する
     */
    public function getRequest()
    {
        return $this->request = Util::helper('object')->newInstanceFromString($this->request);
    }

    /**
     * アクションを実行する
     */
    public function runAction( $name, Response\ResponseIF $response = null, Request\RequestIF $request = null)
    {
        if( $response == null ) $response = $this->getResponse();
        if( $request == null ) $request = $this->getRequest();

        // 実行対象のアクション名
        // 見つからなければ404アクションを実行
        $method = $name.'Action';
        if( !method_exists($this, $method) ) {
            $this->notFoundAction( $response, $request );
            return $response;
        }

        $response->capStart();
        call_user_func( array($this,$method), $response, $request );
        if(!$response->isCapEnd()){
            $response->capEnd();
        }

        return $response;
    }

    /**
     * アクションが見つからなかった時のアクション
     */
    public function notFoundAction( Response\ResponseIF $response, Request\RequestIF $request )
    {
        $response->setStatus(404);
        return $response;
    }
}
