<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:ブートストラップファイル
 *
 * =定数の定義
 * このスクリプトは以下の定数を定義する
 *
 * nora_home
 * :のらのルートディレクトリ
 *
 * =オートローダの起動
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, nora project all rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正bsdライセンス
 * @version    $id$
 */

// nora_homeが定義されていれば処理を継続しない
if( defined('nora_home') ) exit();


// 説明変数 base_path
$base_path = realpath(dirname(__file__).'/../');

// 定数を定義
define('nora_home', $base_path);

// 必要なクラスを全てロードする
require nora_home.'/src/class/base/di/script/bootstrap.php';
require nora_home.'/src/class/logging/script/bootstrap.php';
require nora_home.'/src/class/base/autoloader.php';
require nora_home.'/src/class/base/nora.php';

// ユーティリティをロードする
require nora_home.'/src/util/nora.php';

// オートローダの起動
nora()->setcontainer('nora\base\di\container');
nora()->getcontainer( )->addcomponent('autoloader', 'nora\base\autoloader' );
nora_component('autoloader')
    ->addnamespace('nora', nora_home.'/src/class')
    ->register( );

mb_language('ja');
mb_internal_encoding('utf8');






