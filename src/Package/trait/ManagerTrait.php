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
    protected $cfgFileName;
    protected $env;


    public function __construct( $setup_options = array() )
    {
        $this->setup( $setup_options );
        $this->init();
    }

    public function init( )
    {
        $dir = dir( $this->pkgDirName );
        while( $file = $dir->read() ){
            if( 0 === strpos( $file, '.', 0 ) ) continue;
            $pkgDirName = $this->pkgDirName.'/'.$file;
            $configFile = $pkgDirName.'/'.$this->cfgFileName;
            define('PKG_'.strtoupper($file).'_HOME', $pkgDirName);
            $this->putService('package', $file, function($manager)use($pkgDirName,$configFile){
                $pkg = new Package(array('configFile'=>$configFile,'env'=>$this->env));
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

