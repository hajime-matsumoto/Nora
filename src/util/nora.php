<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト 
 * ユーティリティ関数定義ファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */

/**
 * ユーティリティ関数をロードする
 */
function nora_load_util( $name ) 
{
    require_once NORA_HOME.'/src/util/'.$name.'.php';
}

/**
 * ノラインスタンスを取得する
 */
function nora( )
{
    if( !class_exists('Nora\Base\Nora') ) return false;
    return Nora\Base\Nora::getInstance();
}

