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
namespace NoraModule\Theme\Controller;

use Nora\Application;

/**
 * コントローラー
 */
class StaticController implements Application\ControllerIF
{
    use Application\ControllerTrait;

    public function actionIndex( $req, $res )
    {
        if( !isset($req['request_uri']) ) return;

        $request_uri = $req['request_uri'];
        $file = NORAMODULE_THEME_HOME.'/themes/'.$request_uri;

        if(!file_exists($file)) dir(" $file not found ");

        // ドキュメントルートに書き出す
        $target = $req->getDocumentRoot().'/themes/'.$request_uri;

        $dirname = dirname($target);

        if( !nora_mkdir_recursive($dirname) ) die("ディレクトリ $dirname が作成できません");

        if( is_writable( $target ) die("ターゲット $target に書き込みができません");

        file_put_contents( $target, $contents = file_get_contents( $file ) );
        echo $contents;
        die();
    }
}
