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
use Nora\Service;
use Nora\Bootstrap;
use Nora\Config;

/**
 * モジュール機能
 */
trait ModuleTrait
{
    use General\ParamHolderTrait;
    use Service\InitializableTrait;
    use Bootstrap\BootstrapperOwnerTrait;

    protected $namespace_key       = 'module.namespace';
    protected $dirname_key         = 'module.dirname';
    protected $defaultBootstrapper = 'Nora\Package\ModuleBootstrapper';

    /**
     * サービスマネージャーからイニシャライズされる場合の処理
     */
    public function serviceInitialize( Service\ManagerIF $manager, $setting = array())
    {
        $this->setup( $setting );
        $this->serviceInitialized( );
    }

    /**
     * セットアップを行う
     */
    public function setup( $setting )
    {
        if( !isset($setting['config_file']) ) 
            return new ModuleSetUpException('設定ファイルがありません');
        if( !isset($setting['env']) ) $setting['env'] = 'production';

        $config = Config\Parser\INI::parse( $setting['config_file'], $setting['env']);

        // ネームスペースをオートローダへ登録
        $namespace = $config->getConf( $this->namespace_key );
        $dirname = $config->getConf( $this->dirname_key );
        AutoLoader::getInstance()->addNamespace( $namespace, $dirname );

        // ブートストラッパのセットアップ
        $bs_class_name = $config->getConf('bootstrapper.class', $this->defaultBootstrapper);
        $this->setupBootstrapper( $bs_class_name, $config );
    }


    /**
     * ブートストラッパのセットアップ
     */
    protected function setupBootstrapper( $bs_class_name, $config  )
    {
        $bs = new $bs_class_name( $this );
        $resource = $config->getConf('resource');
        $bs->setResourceSettings( $resource );
        $bs->putResource('config', $config);
        $this->setBootstrapper($bs);
    }
}

