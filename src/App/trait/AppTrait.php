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
use Nora\General;
use Nora\Config;
use Nora\Request;
use Nora\Response;

/**
 * アプリケーション
 */
trait AppTrait
{
    use General\ParamHolderTrait;
    use Service\ManagerTrait;

    /**
     * アプリケーションディレクトリを取得
     */
    public function getDir( $file = null)
    {
        if( $file == null ) return $this->getParam('app_dirname');
        return $this->getParamsF('%s/','app_dirname').$file;
    }

    /**
     * ディレクトリ名とアプリ名を指定して起動
     */
    public function __construct( $app_name, $app_dirname, $app_params = array())
    {
        $this->setParams( $app_params );
        $this->setParam('app_name', $app_name );
        $this->setParam('app_dirname', $app_dirname );

        // 定数を作成する
        $const_name = 'APP_'.strtoupper($app_name).'_HOME';
        if( !defined( $const_name ) ) define($const_name, $app_dirname);

        // 設定値オブジェクトを作成する
        $config_file = $this->getParamsF('%s/config/app.ini','app_dirname');
        $config = Config\Parser\INI::parse( $config_file, $this->getParam('env', 'development') );

        // ブートストラッパーを作成する
        $this->putComponent('bootstrapper',
            $config->getConf('bootstrapper.class', 'Nora\App\Bootstrapper')
        );

        // ブートストラッパに設定値オブジェクトを登録する
        $this->bootstrap( )->putResource('config', $config );
        $this->bootstrap( )->putResource('app', $this );
    }

    /**
     * ブートストラップリソースへのアクセス
     */
    public function bootstrap( $name = null)
    {
        if( $name == null ) return $this->pullComponent('bootstrapper');
        return $this->pullComponent('bootstrapper')->bootstrap( $name );
    }

    /**
     * アプリケーション起動用の関数を返す
     */
    public function getFactory( $app_name, $app_dirname, $app_params = array() )
    {
        $class_name = get_class($this);

        return function( $creator = null )use($app_name,$app_dirname,$app_params, $class_name){
            return new $class_name( $app_name, $app_dirname, $app_params );
        };
    }

    /**
     * リクエストを受け付ける
     */
    public function reciveRequest( $uri, $datas = array( ) )
    {
        $request = $uri instanceof Request\RequestIF ? $uri: $this->makeRequest( $uri );
        $request->setVars( $datas );

        // APIサーバー用のフロントコントローラーを作成する
        $front = $this->bootstrap('ApiFrontController');

        // リクエストをコントローラに渡す
        $front->setRequest( $request );

        $response = $front->dispatch( );
        return $response;
    }

    /**
     * リクエストを作成する
     */
    public function makeRequest( $uri, $datas = array( ) )
    {
        $request = new Request\Request( $datas );
        $request->setParam('request_uri', $uri);
        $request->setVars( $datas );
        return $request;
    }
}
