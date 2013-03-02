<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト 
 * クラスユーティリティ関数定義ファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */

function nora_class_new_instance( $name )
{
	$rc = new ReflectionClass($name);
	return $rc->newInstance( );
}
function nora_class_auto_call_prefixed_method( $object, $prefix, $name )
{
    if(!method_exists($object,$method = $prefix.ucfirst($name))) return;
    return call_user_func_array( array($object,$method),array_slice(func_get_args(),3));
}

