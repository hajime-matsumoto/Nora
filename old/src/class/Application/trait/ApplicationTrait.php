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
use Nora\Config;

/**
 * アプリケーション基本機能
 */
trait ApplicationTrait
{
    use DI\ComponentTrait;

    protected $config;
    protected $env;

    /**
     * 初期化処理
     */
    public function initialize( )
    {
        if( !file_exists( $this->config ) ) return $this->error('Can not read config %s', $this->config );

        // 設定オブジェクトを作成
        $config = new Config\ConfigINI( );
        $config->load( $this->config, $this->env );

        // コンフィグオブジェクトを登録する
        $this->getContainer()->addComponent(
            'config',
            $config
        );

        // 設定ファイルから必要な関数を実行する
        array_walk(
            $config->getConfig('php',array()), 
            function( $v, $k ){ ini_set($v,$k); }
        );
        array_walk(
            $config->getConfig('mb',array()),
            function( $v, $k ){ call_user_func('mb_'.$k, $v); }
        );

        // オートローダにネームスペースとパスを追加
        $this->pullComponent('autoLoader')->addNamespace(
            $config->getConfig('class.namespace'),
            $config->getConfig('class.path')
        );


        // アプリケーション用のブートストラッパを定義する
        $this->getContainer()->addComponent(
            'bootstrapper',
            $config->getConfig(
                'bootstrapper.class',
                'Nora\Application\Bootstrapper'
            )
        );
    }

    /**
     * ブートストラップ
     */
    public function bootstrap( $name )
    {
        return $this->pullComponent( 'bootstrapper' )->pullComponent( $name );
    }

}
