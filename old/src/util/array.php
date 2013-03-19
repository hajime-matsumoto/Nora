<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト 
 * 配列ユーティリティ関数定義ファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */

function nora_array_format( $format, $array  )
{
	return preg_replace('/:([a-zA-Z0-9_]+)/e','nora_array_get( $array, "\1", "")', $format);
}

function nora_array_get( $array, $key, $default = false)
{
	if(!isset($array[$key])) return $default;
	return $array[$key];
}

