<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクトファイル
 *
 * ブートストラップ
 *
 * =定数の定義
 * このスクリプトは以下の定数を定義する
 *
 * NORA_HOME
 * :のらのルートディレクトリ
 *
 * nora_xxx ユーティリティ関数のロード
 * util/nora.php
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, nora project all rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正bsdライセンス
 * @version    $id$
 */
if( !defined('NORA_HOME') )
{
    define('NORA_HOME',realpath(dirname(__file__).'/../'));
}

// インクルードパスを追加する
ini_set('include_path', ini_get('include_path').':'.NORA_HOME.'/src');

// ノラクラスを読み込む
require dirname(__FILE__).'/Nora.php';
