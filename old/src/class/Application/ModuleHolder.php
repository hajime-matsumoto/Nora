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
 * モジュールホルダー
 */
class ModuleHolder implements DI\ComponentIF
{
    use DI\ComponentTrait;

    protected $modulesPath;

    public function initialize( )
    {
        if( !is_dir($this->modulesPath) ) return;

        $dir = dir($this->modulesPath);
        while( $file = $dir->read() )
        {
            if( nora_string_starts_with( $file, '.' ) ) continue;

            $config_file = $this->modulesPath.'/'.$file.'/config/module.ini';
            if( !file_exists( $config_file ) ) continue;


            // 設定オブジェクトを作成
            $config = new Config\ConfigINI( );

            // モジュール用の定数を設定
            $config->load( $config_file, APP_ENV );
            $const_key = strtoupper(str_replace('\\', '_', $config->getConfig('class.namespace') ));
            define( $const_key."_HOME", $this->modulesPath.'/'.$file );

            // モジュールをホルダーに登録する
            $module_name = $file;
            $this->addModule( $module_name, 'Nora\Application\Module', array('config'=>$config_file, 'env'=>APP_ENV) );
        }
    }

    public function addModule( $name, $class, $setting )
    {
        $this->getContainer( )->addComponent($name, $class, $setting );
    }

    public function pullModule( $name )
    {
        return $this->getContainer( )->pullComponent($name);
    }

    public function __get( $name )
    {
        return $this->pullModule( $name );
    }
}
