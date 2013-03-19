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

/**
 * コンポーネントを取得する
 */
function nora_component( $name )
{
    if( !$nora = nora( ) ) return;
    return $nora->getContainer( )->pullComponent( $name );
}

/**
 * starts_with
 */
function nora_string_starts_with($haystack, $needle)
{
    return !strncmp($haystack, $needle, strlen($needle));
}

function nora_string_ends_with($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function nora_mkdir_recursive( $dirname )
{
    if( is_dir($dirname) ) return true;

    // 親がディレクトリでなければ親を作成
    $parent       = dirname($dirname);
    $is_parent_ok = true;
    if( $parent && !is_dir($parent) )
    {
        $is_parent_ok = nora_mkdir_recursive($parent);
    }

    if( !$is_parent_ok || !mkdir($dirname) ) return false;

    return true;
}

function nora_copy( $source, $dist )
{
    if( !nora_mkdir_recursive(dirname($dist)) ) die('Cant create directory for '.$dist);

    copy($source, $dist );
}

function nora_class_create_if_string( &$class, $args = array(), $init = false )
{
    if( is_object($class) )  return $class;

    $rc = new ReflectionClass($class);
    $class = $rc->newInstanceArgs( $args );
    if( is_callable($init) ){
        $init($class);
    }
    return $class;
}



