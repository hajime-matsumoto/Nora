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
namespace Nora\App;

use Nora\Service;
use Nora\General;

/**
 * アプリケーションブートストラッパ
 */
interface BootstrapperIF extends Service\ManagerOwnerIF,Service\ChildManagerIF,Service\InitializableIF,General\Helper\HelperIF
{
    /** 
     * ヘルパとしてコールされた時
     */
    public function bootstrapper( $name = null );

    /**
     * リソースの追加
     */
    public function putResource( $name, $factory );

    /**
     * リソースの取得
     */
    public function pullResource( $name );

    /**
     * 初期化関数
     */
    public function bootstrap( $name = null );
}
