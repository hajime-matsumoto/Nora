<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:ブートストラップファイル
 *
 * =定数の定義
 * このスクリプトは以下の定数を定義する
 *
 * NORA_HOME
 * :のらのルートディレクトリ
 *
 * =オートローダの起動
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */

// NORA_HOMEが定義されていれば処理を継続しない
if( defined('NORA_HOME') ) exit();


// 説明変数 base_path
$base_path = realpath(dirname(__FILE__).'/../');

// 定数を定義
define('NORA_HOME', $base_path);

// ユーティリティをロードする
require NORA_HOME.'/src/util/nora.php';

// ロギングユーティリティを有効化
nora_load_util('logging');

// オートローダの起動
require NORA_HOME.'/src/class/Base/AutoLoader.php';

$loader = Nora\Base\AutoLoader::getInstance();
$loader->addNamespace('Nora', NORA_HOME.'/src/class');
$loader->register( );

new Nora\Base\Nora();




