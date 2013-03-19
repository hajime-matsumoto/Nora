<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\General\Helper;

/**
 * ヘルパー機能
 */
trait HelperTrait
{

    public function __invoke( )
    {
        $full_name  = get_class($this);
        $pos        = strrpos($full_name,'\\');
        $class_name = substr($full_name,$pos+1);
        $method     = array($this,$class_name);
        return call_user_func_array($method, func_get_args());
    }

    public function setBroker( $broker )
    {
        $this->_broker = $broker;
    }

    public function getBroker( )
    {
        return $this->_broker;
    }

}
