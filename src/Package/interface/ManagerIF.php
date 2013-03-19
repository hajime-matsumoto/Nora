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
interface ManagerIF extends General\SetupableIF, General\ParamHolderIF, General\Helper\HelperIF, Service\ManagerIF
{
    public function __construct( $setup_options = array() );
    /**
     * ヘルパメソッド
     */
    public function manager( $pkgName = null);
}

