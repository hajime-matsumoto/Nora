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

namespace Nora\Bootstrap;

use Nora\Service;
use Nora\General\Helper;

/**
 * ブートストラッパ
 * ヘルパとしても使用可能
 */
interface BootstrapperIF  extends Service\ManagerIF,Helper\HelperIF
{
    /**
     * ヘルパメソッド
     */
    public function bootstrapper( $name = null );

    /**
     * リソースをセットする
     */
    public function putResource( $name, $resource, $setting = array() );

    /**
     * リソースを取得する
     */
    public function pullResource( $name );
}

