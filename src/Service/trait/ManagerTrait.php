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
namespace Nora\Service;

require_once 'Service/trait/ManagerOwnerTrait.php';

/**
 * サービスマネージャー基本機能
 */
trait ManagerTrait
{
    use ManagerOwnerTrait;

    // サービスレジストリ
    private $_service_registry = array();

    // サービスファクトリ
    private $_service_factory = array();

    // サービス設定
    private $_service_setting = array();

    // 初期化済フラグ
    private $_service_initialized = array();


    /**
     * タイプをフォーマットする
     */
    public function formatType( $unformated_type )
    {
        return strtolower($unformated_type);
    }

    /**
     * サービス名をフォーマットする
     */
    public function formatName( $unformated_name )
    {
        return strtolower($unformated_name);
    }

    /**
     * コンポーネントショートハンド:put
     */
    public function putComponent( $unformated_name, $factory, $setting = array())
    {
        return $this->putService( 'component', $unformated_name, $factory, $setting);
    }

    /**
     * コンポーネントショートハンド:pull
     */
    public function pullComponent( $unformated_name )
    {
        return $this->pullService( 'component', $unformated_name );
    }



    /**
     * サービスを設置する
     */
    public function putService( $unformated_type, $unformated_name, $factory, $setting = array() )
    {
        if( $this->hasService( $unformated_type, $unformated_name ) ) 
            throw new ServiceAlradyExistsException( $unformated_type, $unformated_name );
        $this->registerServiceFactory( $unformated_type, $unformated_name, $factory, $setting );
    }

    /**
     * サービスディレクトリを設置する
     */
    public function putServiceDir( $unformated_type, $dir_name, $prefix, $sufix = null )
    {
        if( !is_dir($dir_name) ) throw new ServiceDirectoryNotExistsException( $dir_name );

        $dir = dir($dir_name);
        while( $file = $dir->read() )
        {
            if( $file{0} == '.' ) continue;
            if( substr( $file, strlen( $file ) - strlen( $sufix.'.php' ) ) != $sufix.'.php' ) continue;


            $class = substr($file, 0, strlen($file) - strlen('.php'));
            $unformated_name = substr($class, 0, strlen($class) - strlen($sufix));
            $this->putService( $unformated_type, $unformated_name, $prefix.'\\'.$class );
        }
    }

    /**
     * サービスを登録する
     */
    public function registerService( $unformated_type, $unformated_name, $service )
    {
        if( !is_object($service) ) throw new ServiceCantBeNullException( $unformated_type, $unformated_name );

        $name = $this->formatName($unformated_name);
        $type = $this->formatType($unformated_type);

        $this->_service_registry[$type][$name] = $service;
    }

    /**
     * サービスのファクトリを登録する
     */
    public function registerServiceFactory( $unformated_type, $unformated_name, $factory, $setting = array() )
    {
        $name = $this->formatName($unformated_name);
        $type = $this->formatType($unformated_type);

        $this->_service_factory[$type][$name] = $factory;

        if(isset($this->_service_setting[$type][$name]))
        {
            $setting = array_merge($this->_service_setting[$type][$name], $setting);
        }
        $this->_service_setting[$type][$name] = $setting;
    }


    /**
     * サービスを取得する
     *
     * @exception ServiceNotFoundException
     */
    public function pullService( $unformated_type, $unformated_name )
    {
        // 登録済なら登録されたサービスを返す
        if( $this->isServiceRegistered( $unformated_type, $unformated_name ) ) return $this->getService( $unformated_type, $unformated_name );

        // 自分に登録されていなければ親を探す
        if( !$this->hasService( $unformated_type, $unformated_name ) )
        {
            if( !$this->hasServiceManager( ) ) throw new ServiceNotFoundException( $unformated_type, $unformated_name );
            return $this->getServiceManager( )->pullService( $unformated_type, $unformated_name);
        }

        // ファクトリのみ登録されている状態

        // サービスを作成する
        $service = $this->createService( $unformated_type, $unformated_name );

        // サービスを初期化する
        if( $service instanceof InitializableIF )
        {
            if( !$service->isServiceInitialized( ) )
            {
                $service->serviceInitialize( $this, $this->getServiceSetting($unformated_type, $unformated_name) );
            }
        }

        // サービスを登録する
        $this->registerService( $unformated_type, $unformated_name, $service );

        return $this->getService( $unformated_type, $unformated_name );
    }

    /**
     * サービスが存在するか
     */
    public function hasService( $unformated_type, $unformated_name )
    {
        if( $this->isServiceRegistered( $unformated_type, $unformated_name ) ) return true;
        if( $this->isServiceFactoryRegistered( $unformated_type, $unformated_name ) ) return true;
        return false;
    }

    /**
     * サービスを取得
     */
    public function getService( $unformated_type, $unformated_name )
    {
        $name = $this->formatName($unformated_name);
        $type = $this->formatType($unformated_type);
        return $this->_service_registry[$type][$name];
    }

    /**
     * ファクトリを取得
     */
    public function getServiceFactory( $unformated_type, $unformated_name )
    {
        $name = $this->formatName($unformated_name);
        $type = $this->formatType($unformated_type);
        return $this->_service_factory[$type][$name];
    }

    /**
     * ファクトリ設定値を取得
     */
    public function getServiceSetting( $unformated_type, $unformated_name )
    {
        $name = $this->formatName($unformated_name);
        $type = $this->formatType($unformated_type);
        return $this->_service_setting[$type][$name];
    }

    /**
     * ファクトリ設定値を取得
     */
    public function setServiceSetting( $unformated_type, $unformated_name, $setting )
    {
        $name = $this->formatName($unformated_name);
        $type = $this->formatType($unformated_type);
        $this->_service_setting[$type][$name] = $setting;
        return $this;
    }

    /**
     * サービスを作成
     */
    public function createService( $unformated_type, $unformated_name )
    {
        $factory = $this->getServiceFactory( $unformated_type, $unformated_name );

        // ファクトリがクロージャーであれば
        if( $factory instanceof \Closure ) return $factory( $this );

        // ファクトリがオブジェクトだったら
        if( is_object($factory) ) return $factory;

        // ファクトリが配列だったら
        if( is_array($factory) && is_callable($factory) ) 
            return call_user_func( $factory, $this, $this->getServiceSetting($unformated_type,$unformated_name ));

        // ファクトリが文字列だったら
        if( is_string($factory) && class_exists($factory) ) {
            // シングルトンだったら
            if( is_subclass_of( $factory, 'Nora\General\SingletonIF' ) ) 
                return $factory::getInstance();
            return new $factory( $this, $unformated_type, $unformated_name );
        }

        throw new CreateServiceException( sprintf("サービスが作成できません タイプ[%s] なまえ[%s]", $unformated_type, $unformated_name ) );
    }

    /**
     * サービスを削除
     */
    public function removeService( $unformated_type, $unformated_name )
    {
        $name = $this->formatName($unformated_name);
        $type = $this->formatType($unformated_type);

        if(isset($this->_service_initialized[$type][$name]))
            unset($this->_service_initialized[$type][$name]);
        if(isset($this->_service_registry[$type][$name]))
            unset($this->_service_registry[$type][$name]);
        if(isset($this->_service_factory[$type][$name]))
            unset($this->_service_factory[$type][$name]);
        if(isset($this->_service_setting[$type][$name]))
            unset($this->_service_setting[$type][$name]);
    }

    /**
     * サービスが初期化されているか
     */
    public function isInitialized( $unformated_type, $unformated_name )
    {
        $name = $this->formatName($unformated_name);
        $type = $this->formatType($unformated_type);

        return isset($this->_service_initialized[$type][$name]) ? true: false;
    }

    /**
     * サービスの初期化
     */
    public function initialize( $unformated_type, $unformated_name, $service )
    {
        $name = $this->formatName($unformated_name);
        $type = $this->formatType($unformated_type);

        if( $service instanceof InitializableIF )
        {
            $service->serviceInitialize( $this );
        }

        $this->_service_initialized[$type][$name] = true;
        return $service;
    }


    /**
     * サービスがレジストされているか
     */
    public function isServiceRegistered( $unformated_type, $unformated_name )
    {
        $name = $this->formatName($unformated_name);
        $type = $this->formatType($unformated_type);
        return isset($this->_service_registry[$type][$name]) ? true: false;
    }

    /**
     * サービスファクトリがレジストされているか
     */
    public function isServiceFactoryRegistered( $unformated_type, $unformated_name )
    {
        $name = $this->formatName($unformated_name);
        $type = $this->formatType($unformated_type);
        return isset($this->_service_factory[$type][$name]) ? true: false;
    }

}


/**
 * サービスが見つからなかった時の例外
 */
class ServiceNotFoundException extends \Exception
{
    public function __construct( $type, $name )
    {
        parent::__construct( sprintf('サービスが見つかりません。タイプ[%s] なまえ[%s]', $type, $name ) );
    }
}
/**
 * サービスが作れなかった時の例外
 */
class CreateServiceException extends \Exception
{
}

class ServiceAlradyExistsException extends \Exception
{
    public function __construct( $unformated_type, $unformated_name )
    {
        parent::__construct( sprintf('サービスは既に登録されています。タイプ[%s] なまえ[%s]', $unformated_type, $unformated_name ) );
    }
}
class ServiceCantBeNullException extends \Exception
{
    public function __construct( $unformated_type, $unformated_name )
    {
        parent::__construct( sprintf('サービスはオブジェクトでなければいけません。タイプ[%s] なまえ[%s]', $unformated_type, $unformated_name ) );
    }
}
class ServiceDirectoryNotExistsException extends \Exception
{
    public function __construct( $dir_name )
    {
        parent::__construct( sprintf('サービスディレクトリが存在しません %s', $dir_name ) );
    }
}

