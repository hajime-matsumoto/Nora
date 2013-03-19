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
namespace Nora\Package;

use Nora\Bootstrap;
use Nora\Service;
use Nora\Controller;

/**
 * ブートストラッパ
 */
class ModuleBootstrapper implements Bootstrap\BootstrapperIF
{
    use Bootstrap\BootstrapperTrait;

    private $_module;

    public function __construct( ModuleIF $module )
    {
        $this->initMethodFactory( );
        $this->_module = $module;
    }

    public function _initFrontController( Service\ManagerIF $manager, $setting )
    {
        $front = new Controller\FrontController( );
        $front->setHelperBroker(new \Nora\General\Helper\Broker());
        $front->getHelperBroker( )->putHelper('bootstrapper', $this);
        $front->getHelperBroker( )->putHelper('module', $this->_module);
        $front->getHelperBroker( )->putHelper('config', $this->bootstrap('config'));
        $front->setup( 'rootDir', $this->bootstrap('config')->getConf('module.dirname'));
        $front->setup( $setting );
        return $front;
    }
}
