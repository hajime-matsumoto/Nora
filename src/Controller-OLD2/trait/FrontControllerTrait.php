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

/**
 * フロントコントローラ
 */
trait FrontControllerTrait
{
    use General\SetupableTrait;
    use General\ParamHolderTrait;
    use General\Helper\BrokerOwnerTrait;

    protected $defaultModuleName      = 'default';
    protected $defaultControllerName = 'home';
    protected $defaultActionName      = 'index';
    protected $request                = 'Nora\Request\Request';
    protected $response               = 'Nora\Response\Response';
    protected $router                 = 'Nora\Router\Router';
    protected $dispatcher             = 'Nora\Controller\Dispatcher';
    protected $rootDir;

    private $_controller_dir = array();

    public function formatModuleName( $unformatted_module_name ) 
    {
        return strtolower($unformatted_module_name);
    }

    public function setControllerDir( $uf_module, $dir = null )
    {
        if( $dir == null && is_array($uf_module) ) {
            $dirnames = $uf_module;
            foreach($dirnames as $uf_module=>$dirname) {
                $this->setControllerDir($uf_module, $dirname);
            }
            return;
        }

        if( $dir == null ){
            $dir = $uf_module;
            $module = $this->defaultModuleName;
        }else{
            $module = $this->formatModuleName( $uf_module );
        }

        if($dir{0}) $dir = $this->rootDir.'/'.$dir;

        if( !is_dir( $dir ) ) 
            throw new SetControllerDirException("ディレクトリが存在しません。$dir ");
        $dir = realpath($dir);

        $this->_controller_dir[$this->defaultModuleName] = $dir;
    }

    public function getControllerDir( $uf_module = null )
    {
        $module = $this->formatModuleName( $uf_module );

        if($module == null ) $module = $this->defaultModuleName;
        $dir = $this->_controller_dir[$module];
        return $dir;
    }

    public function setControllerNamespace( $uf_module, $namespace = null)
    {
        // 引数が一つだったら変数を入れ替え
        if($namespace == null ) {
            $namespace = $uf_module;
            $module = $this->defaultModuleName;
        }else{
            $module = $this->formatModuleName($uf_module);
        }

        // 第一引数が配列じゃなければ正常処理
        if( !is_array($namespace) ) {
            $this->_controller_namespace[$module] = $namespace;
            return;
        }

        // 複数指定の場合にこの処理
        $namespaces = $namespace;
        foreach($namespaces as $uf_module=>$namespace) {
            $this->setControllerNamespace($uf_module,$namespace);
        }
    }

    public function getControllerNamespace( $uf_module = null )
    {
        if($uf_module == null ) $module = $this->defaultModuleName;
        else $module = $this->formatModuleName($uf_module);

        return $this->_controller_namespace[$module];
    }

    public function pullController( $module_name, $controller_name )
    {
        $dir = $this->getControllerDir( $module_name );
        $file = $dir.'/'.ucfirst($controller_name).'.php';
        $namespace = $this->getControllerNamespace( $module_name );
        $class = $namespace.'\\'.ucfirst($controller_name);

        if(file_exists($file)) require_once $file;

        try {
            // コントローラを作成する
            $controller = new $class();
        }catch( Exception $e ){
            throw new CreateControllerClassException("$class が存在しません {message:$e}" );
        }

        // コントローラに必要なデータを引き渡す
        $controller->setHelperBroker( $this->getHelperBroker( ) );
        $controller->setParams($this->getParams());
        $controller->setup('controllerName', $controller_name);
        return $controller;
    }

    public function initInstance( &$object )
    {
        if( is_object($object) ) return $object;
        $object = new $object();
        return $object;
    }

    public function dispatch( )
    {
        // Dispatcherのセットアップ
        $dispatcher = $this->initInstance($this->dispatcher);
        $dispatcher->setParams( $this->getParams() );
        $dispatcher->setup('front', $this );
        $dispatcher->setup('request',clone $this->initInstance($this->request));
        $dispatcher->setup('response',clone $this->initInstance($this->response));
        $dispatcher->setup('defaultModuleName',$this->defaultModuleName);
        $dispatcher->setup('defaultControllerName',$this->defaultControllerName);
        $dispatcher->setup('defaultActionName',$this->defaultActionName);

        // Dispatchの実行
        $max = 10;
        for($i=0;true;$i++)
        {
            $response = $dispatcher->dispatch( );

            if( !$dispatcher->hasNext( ) ) break;

            if( $max == $i ) {
                $params = $dispatcher->getLastRequest()->getParams();
                throw new TooMachDispatchLoop( var_export($params,true) );
            }
        }

        return $response;
    }
}

class TooMachDispatchLoop extends \Exception { }
class SetControllerDirException extends \Exception{ }
