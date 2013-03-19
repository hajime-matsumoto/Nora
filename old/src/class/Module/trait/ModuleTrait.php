<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Module
 * @package    Module
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Module;

use Nora\Base\DI;

/**
 * モジュール機能
 */
trait ModuleTrait
{
    use DI\ComponentTrait;

    private $_name;
    private $_namespace;
    private $_directory;
    private $_config;

    static public function factory( $module_name,$module_directory )
    {
        $module = new static( );
        $module->setName( $module_name );
        $module->setDirectory( $module_directory );
        $module->setConfig($module_directory.'/config/module.ini', APP_ENV);
        $module->initialize();
        return $module;
    }

    /**
     * モジュール名をセットする
     */
    public function setName( $name )
    {
        $this->_name = $name;
    }

    /**
     * モジュールのネームスペースをセットする
     */
    public function setNamespace( $namespace )
    {
        $this->_namespace = $namespace;
    }

    /**
     * モジュールのディレクトリをセットする
     */
    public function setDirectory( $directory )
    {
        $this->_directory = $directory;
    }

    /**
     * コンフィグをセットする
     */
    public function setConfig( $config_file, $env )
    {
        $config = new \Nora\Config\ConfigINI();

        // 設定を取得する
        if( file_exists($config_file) )
        {
            $config->load( $config_file, APP_ENV );

            $module_namespace = $config['class']['namespace'];
            $this->setNamespace( $module_namespace );

            // モジュール用の定数を定義
            define(
                strtoupper(str_replace('\\','_',$module_namespace)).'_HOME',
                $this->_directory
            );

            $config->load($config_file, $env);

            // オートローダを設定する
            nora_component('autoLoader')->addNamespace( $config['class']['namespace'], $config['class']['path'] );
        }
        $this->_config = $config;
    }


    /**
     * コンフィグを取得する
     */
    public function getConfig( )
    {
        return $this->_config;
    }

    /**
     * モジュールの初期化
     */
    public function initialize( )
    {
    }

    /**
     * モジュールのクラスを作成
     */
    public function newInstance( $class )
    {
        return nora_class_new_instance( $this->_namespace .'\\'. $class );
    }

    /**
     * モジュールのファイルを取得
     */
    public function getFilePath( $file )
    {
        return $this->_directory.'/'.$file;
    }
}
