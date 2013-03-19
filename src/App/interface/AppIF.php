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

/**
 * アプリケーションインターフェイス
 */
interface AppIF extends Service\ManagerIF
{
    /**
     * アプリケーションディレクトリを取得
     */
    public function getDir( $file = null);

    /**
     * ブートストラップリソースへのアクセス
     */
    public function bootstrap( $name = null);

    /**
     * アプリケーション起動用の関数を返す
     */
    public function getFactory( $app_name, $app_dirname, $app_params = array() );
}
