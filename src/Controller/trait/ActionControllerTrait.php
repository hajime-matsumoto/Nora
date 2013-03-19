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
use Nora\General\Helper;
use Nora\Request;
use Nora\Response;

trait ActionControllerTrait
{
    use Helper\BrokerOwnerTrait;
    use General\ParamHolderTrait;


    public function action( $act_name, Request\RequestIF $request = null, Response\ResponseIF $response = null )
    {
        if( !method_exists( $this, $method = ucfirst($act_name)."Action") )
        {
            throw new ActionNotFoundException( $this->getParam('name').'::'.$method );
        }

        $response->setParam('ctrl_name', $this->getParam('name'));
        $response->setParam('act_name', $act_name);

        call_user_func( array($this, $method), $request, $response );

        return $response;
    }


    public function __call( $name, $args )
    {
        return $this->helper($name)->invokeArgs($args);
    }

}


class ActionNotFoundException extends \Exception
{
}
