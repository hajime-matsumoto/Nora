<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト 
 * ロギングユーティリティ関数定義ファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */

function nora_logger( )
{
    if( nora( ) && nora( )->getContainer( )->hasComponent('logger') )
    {
        return nora( )->getContainer( )->pullComponent('logger');
    }
}


function nora_logging_level_name( $level )
{
    return nora_logger()->leveltolabel($lavel);
}

/**
 * レポーティングレベルを設定、もしくは取得する
 */
function nora_logging_reporting_level( $level = null )
{
    return nora_logger()->reportingLevel( $lavel );
}

/**
 * 引数が２個以上であれば、$messageをフォーマットとしてvsprintfする
 *
 * もし、Noraが起動していれば処理をフォワードする
 */
function nora_logging( $level, $message )
{
    return nora_logger( )->loggingArray($level, array_slice(func_get_args(),1));
}

/**
 * ログイングをする
 */
function nora_logging_array( $level, $args )
{
	return nora_logger()->loggingArray( $level, $args );
}


/**
 * デバッグメッセージをロギングする
 */
function nora_debug( $message )
{
	return nora_logger()->debug(func_get_args());
}
/**
 * ノーティスメッセージをロギングする
 */
function nora_notice( $message )
{
	return nora_logger()->notice(func_get_args());
}
/**
 * 警告メッセージをロギングする
 */
function nora_warn( $message )
{
	return nora_logger()->warn(func_get_args());
}
/**
 * エラーメッセージをロギングする
 */
function nora_error( $message )
{
	return nora_logger()->error(func_get_args());
}

