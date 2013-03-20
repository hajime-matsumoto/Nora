<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 * テストファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, nora project all rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正bsdライセンス
 * @version    $id$
 */

namespace Nora\Package;

use Nora\AutoLoader\AutoLoader;
use Nora\General;
use Nora\General\Helper;
use Nora\Service;
use Nora\Bootstrap;
use Nora\Config\Config;
use Nora\Request;
use Nora\Response;

/**
 * パッケージ機能
 */
trait PackageTrait
{
    use General\ParamHolderTrait;
    use Helper\HelperTrait;
    use Helper\BrokerOwnerTrait;
    use Service\InitializableTrait;
    use Bootstrap\BootstrapperOwnerTrait;
    use General\SetupableTrait;

    protected $configFile;
    protected $env = 'production';

    public function __construct( $setup_options = array() )
    {
        $this->setup( $setup_options );
    }

    /**
     * 初期化する
     */
    public function serviceInitialize( Service\ManagerIF $manager, $setting = array() )
    {
        $this->init();
        $this->serviceInitialized();
    }


    /**
     * ヘルパメソッド
     */
    public function package()
    {
        return $this;
    }

    /**
     * リクエストを作成する
     */
    public function makeRequest()
    {
        $req = new Request\Request();
        $req->setParam('pkg_name',$this->getParam('name'));
        return $req;
    }

    /**
     * レスポンスを作成する
     */
    public function makeResponse()
    {
        $res = new Response\Response();
        $res->setParam('pkg_name',$this->getParam('name'));
        return $res;
    }



    /**
     * 初期化処理
     */
    public function init()
    {
        // コンフィグの作成
        $config = new Config( );
        $config->importINIFile( $this->configFile, $this->env );

        // パッケージ名をパラメタに登録
        $this->setParam('name', $config->getConf('pkg.name'));

        // ネームスペースとライブラリをオートローダに登録
        Autoloader::getInstance()->addNamespace( $config->getConf('pkg.namespace'),$config->getConf('pkg.src') );

        // Vendorをインクルードパスに追加する
        if( $config->hasConf('vendor.path') ) {
            ini_set('include_path', ini_get('include_path').':'.$config('vendor.path'));
        }

        // ブートストラッパの組み込み
        $this->_buildBootstrapper( $config );

        // ヘルパブローカの組み込み
        $this->_buildHelperBroker( );
    }

    protected function _buildBootstrapper( $config )
    {
        // ブートストラッパの取得
        $class = $config->getConf('bootstrapper.class','Nora\Package\Bootstrapper');
        $bs = new $class();
        $bs->putResource('config',$config);
        $bs->putResource('package',$this);

        // ブートストラッパの組み込み
        $this->setBootstrapper( $bs );
    }

    protected function _buildHelperBroker( )
    {
        // パッケージ用ヘルパの作成
        $helperBroker = new Helper\Broker();
        $helperBroker->putHelper('bootstrap', $this->getBootstrapper());
        $helperBroker->putHelper('config', $this->bootstrap('config'));
        $helperBroker->putHelper('package', $this);

        // ヘルパーの組み込み
        $this->setHelperBroker( $helperBroker );
    }

    /**
     * パッケージライブラリからクラスを呼び出す
     */
    public function newInstance( $class_name )
    {
        $class = $this->config('pkg.namespace').'\\'.$class_name;
        $rc = new \ReflectionClass($class);
        return $rc->newInstanceArgs(array_slice(func_get_args(),1));
    }

    /**
     * コントローラがあるか
     */
    public function hasController( $ctrl_name )
    {
        try {
            if(class_exists( $this->_getControllerClassName($ctrl_name) )){
                return true;
            }
        }catch(Exception $e){
            return false;
        }
        return false;
    }

    /**
     * コントローラを取得
     */
    public function pullController( $ctrl_name )
    {
        $ctrl_class = $this->_getControllerClassName($ctrl_name);
        $ctrl = new $ctrl_class();
        $ctrl->setParam('name',$ctrl_name);
        $ctrl->setHelperBroker( $this->getHelperBroker() );
        return $ctrl;
    }

    private function _getControllerClassName( $ctrl_name )
    {
        return $ctrl_class = $this->config( )->sprintf(
            '%s\\%s'.ucfirst($ctrl_name).'%s',
            'controller.namespace',
            'controller.classPrefix',
            'controller.classPostfix'
        );
    }


    /**
     * コントロールアクションの実行
     */
    public function action( $ctrl_name, $act_name, Request\RequestIF $request = null, Response\ResponseIF $response = null )
    {
        $ctrl = $this->pullController($ctrl_name);
        $ctrl->action( $act_name, $request, $response );
    }

    /**
     * ヘルパをショートハンドで呼び出せるようにする
     */
    public function __call( $name, $args )
    {
        return $this->helper($name)->invokeArgs($args);
    }


}

