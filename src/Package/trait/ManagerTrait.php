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

use Nora\General;
use Nora\Service;

/**
 * パッケージマネージャー機能
 */
trait ManagerTrait
{
    use General\SetupableTrait;
    use General\ParamHolderTrait;
    use General\Helper\HelperTrait;
    use Service\ManagerTrait;

    protected $pkgDirName;
    protected $cfgFileName = "config/pkg.ini";
    protected $env = "production";


    public function __construct( $setup_options = array(), $init = true )
    {
        $this->setup( $setup_options );
        if( $init == true ) $this->init();
    }

    public function init( )
    {
        $this->loadPackagesDirectory($this->pkgDirName, $this->cfgFileName, $this->env );
    }

    public function loadPackagesDirectory( $pkgDirName, $cfgFileName = null, $env = null )
    {
        if( $pkgDirName == null ) return;
        if( $cfgFileName == null ) $cfgFileName = $this->cfgFileName;
        if( $env == null ) $env = $this->env;


        $dir = dir( $pkgDirName );
        while( $file = $dir->read() ){
            if( 0 === strpos( $file, '.', 0 ) ) continue;

            // パッケージディレクトリを定義する
            $myPkgDirName = $pkgDirName.'/'.$file;

            // パッケージ設定ファイルを定義する
            $configFile = $myPkgDirName.'/'.$cfgFileName;

            // パッケージ用の定数を定義する
            define('PKG_'.strtoupper($file).'_HOME', $myPkgDirName);

            // パッケージを登録する
            $this->putService('package', $file, function($manager)use($myPkgDirName,$configFile,$env){
                $pkg = new Package(array('configFile'=>$configFile,'env'=>$env));
                $pkg->serviceInitialize($manager);
                $pkg->getHelperBroker( )->putHelper('pkgManager', $this);
                return $pkg;
            });
        }
    }

    public function pullPackage( $pkgName )
    {
        return $this->pullService('package', $pkgName);
    }

    public function hasPackage( $pkgName )
    {
        return $this->hasService('package', $pkgName);
    }

    /**
     * ヘルパメソッド
     */
    public function manager( $pkgName = null)
    {
        if( $pkgName == null ) return $this;
        return $this->pullPackage( $pkgName );
    }
}

