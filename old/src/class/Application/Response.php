<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   View
 * @package    Response
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Application;

use Nora\View;

/**
 * アプリケーションレスポンス
 */
class Response extends \ArrayObject implements View\ResponseIF
{
    use View\ResponseTrait;

    private $_result;
    private $_action_name;
    private $_controller_name;

    public function setResult( $result )
    {
        $this->_result = $result;
    }

    public function getResult( )
    {
        return $this->_result;
    }

    public function setActionName( $action_name )
    {
        $this->_action_name = $action_name;
    }

    public function setControllerName( $controller_name )
    {
        $this->_controller_name = $controller_name;
    }

    public function getStatus( )
    {
        return array('action_name'=>$this->_action_name,'controller_name'=>$this->_controller_name,'result'=>$this->_result);
    }
}
