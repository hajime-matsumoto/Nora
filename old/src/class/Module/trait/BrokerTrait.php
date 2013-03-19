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

/**
 * モジュールブローカー
 */
trait BrokerTrait
{
    private $_modules = array();
    private $_default_module = 'default';

    /**
     * モジュールを取得する
     */
    public function getModules( )
    {
        return $this->_modules;
    }

    /**
     * モジュールを取得する
     */
    public function getModule( $module_name )
    {
        if( !$this->hasModule( $module_name ) ) return;
        return $this->_modules[$module_name];
    }

    /**
     * モジュールが存在するか？
     */
    public function hasModule( $module_name )
    {
        return isset($this->_modules[$module_name]) ? true: false;
    }

    /**
     * デフォルトモジュールを追加
     *
     * @param ネームスペース
     * @param ディレクトリ
     */
    public function setDefaultModule( $module_directory )
    {
        $this->addModule( $this->_default_module, $module_directory );
    }

	/**
	 * モジュールを追加
     *
     * @param 名前
     * @param ネームスペース
     * @param ディレクトリ
     */
    public function addModule( $module_name, $module_directory )
    {
        $this->_modules[$module_name] = Module::factory($module_name,$module_directory);
    }

    /**
     * モジュールディレクトリを追加
     */
    public function addModulesDir( $dirname )
    {
        if(!is_dir( $dirname )) return false;

        $dir = dir($dirname);

        while( $file = $dir->read() )
        {
            if( nora_string_starts_with($file,'.') ) continue;

            $module_name = $file;
            $module_directory = $dirname.'/'.$file;

            $this->addModule( $module_name, $module_directory );
        }
    }
}


