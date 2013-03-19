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
namespace Nora\App;

use Nora\Service;
use Nora\Controller;

/**
 * ブートストラッパ
 */
class Bootstrapper implements BootstrapperIF
{
    use BootstrapperTrait;


    public function _initApiFrontController( )
    {
        $config = $this->pullResource('config');
        $front = new Controller\FrontController();
        $front->setModuleNamespace( $config->getConf('api.namespace') );
        $front->setControllerDir( 
            $this->pullResource('app')->getDir(
                $config->getConf('api.controllerDir')
            )
        );
        $front->getHelperBroker( )->putHelper('bootstrapper', $this );
        $front->getHelperBroker( )->putHelper('front', $front );
        return $front;
    }
}
