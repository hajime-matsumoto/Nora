<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクトファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, nora project all rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正bsdライセンス
 * @version    $id$
 */
namespace Nora;

use Nora\General;
use Nora\Service;

require_once 'General/SingletonIF.php';
require_once 'General/SingletonTrait.php';
require_once 'AutoLoader/interface/AutoLoaderIF.php';
require_once 'AutoLoader/AutoLoader.php';
require_once 'Service/interface/ManagerIF.php';
require_once 'Service/interface/InitializableIF.php';
require_once 'Service/trait/ManagerTrait.php';
require_once 'Service/trait/InitializableTrait.php';

/**
 * のらクラス
 */
class Nora implements General\SingletonIF,Service\ManagerIF
{
    use General\SingletonTrait;
    use Service\ManagerTrait;

    /** 
     * シングルトンオンリーにする 
     * 定数 NORA_HOMEの定義
     * AutoLoaderの起動と設定
     */
    private function __construct( )
    {
        $this->putService('component', 'autoLoader', 'Nora\AutoLoader\AutoLoader');
        $this->putService('component', 'util', 'Nora\Util\Util');

        $this->pullService('component', 'autoLoader')->addNamespace( 'Nora', NORA_HOME.'/src' );
    }

    /**
     * オートローダを取得する
     */
    static public function autoLoader( )
    {
        return static::getInstance( )->pullService('component', 'autoLoader');
    }

    /**
     * ユーティリティを取得する
     */
    static public function util( )
    {
        return static::getInstance( )->pullService('component', 'util');
    }
}
