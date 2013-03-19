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
namespace Nora\Util;

require_once 'General/SingletonIF.php';
require_once 'General/SingletonTrait.php';
require_once 'Service/interface/ManagerIF.php';
require_once 'Service/trait/ManagerTrait.php';


use Nora\General;
use Nora\Service;

/**
 * ユーティリティ
 */
class Util implements General\SingletonIF,Service\ManagerIF
{
    use General\SingletonTrait;
    use Service\ManagerTrait;

    /** シングルトンオンリー */
    private function __construct( )
    {
        $this->putServiceDir('helper', dirname(__FILE__), 'Nora\Util', 'Helper');
    }

    /**
     * ヘルパを取得
     */
    static public function helper( $name )
    {
        return static::getInstance()->pullService('helper', $name);
    }
}

