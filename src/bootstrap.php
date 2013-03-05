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

// 必要なクラスを全てロードする
require NORA_HOME.'/src/class/Base/DI/script/bootstrap.php';
require NORA_HOME.'/src/class/Logging/script/bootstrap.php';
require NORA_HOME.'/src/class/Base/AutoLoader.php';
require NORA_HOME.'/src/class/Base/Nora.php';

// ユーティリティをロードする
require NORA_HOME.'/src/util/nora.php';

// オートローダの起動
nora()->getContainer( )->addComponent('autoLoader', 'Nora\Base\AutoLoader' );
nora_component('autoLoader')
    ->addNamespace('Nora', NORA_HOME.'/src/class')
    ->register( );

mb_language('ja');
mb_internal_encoding('utf8');






