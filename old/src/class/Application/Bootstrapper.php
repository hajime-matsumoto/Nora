<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Application
 * @package    Application
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Application;

use Nora\Base\DI;

/**
 * アプリケーションブートストラッパ
 */
class Bootstrapper implements DI\BootstrapperIF
{
    use DI\BootstrapperTrait;

    public function initialize( )
    {
        if( !$config = $this->pullComponent('config') ) return;

        // Resource設定があればリソースに反映する
        $this->resourceInitialize( $config->getConfig('resource',array()) );
    }

    public function _initController( $setting )
    {
        return $setting;
    }

    public function _initView( $setting = array() )
    {
        return new \Nora\View\View();
    }

    public function _initLayout( $setting )
    {
        return $setting;
    }

    public function _initMailer( $setting )
    {
        return new \Nora\Mail\Mailer();
    }

    public function _initResponse( $setting )
    {
        $res = new \Nora\Application\Response();
        $res->setView( $this->bootstrap('view') );
        return $res;
    }

    public function _initRequest( $setting )
    {
        return new \Nora\Web\Request();
    }

    public function _initRouter( )
    {
        return new \Nora\URI\Router();
    }

    public function _initModules( )
    {
        return new \Nora\Application\ModuleHolder( );
    }

    public function _initFrontController( )
    {
        //return new \Nora\Application\FrontController( );
        //return new \Nora\Application\FrontController( );
    }

    public function bootstrap( $name )
    {
        return $this->pullComponent($name);
    }

}
