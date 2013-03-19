<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Util;

use ReflectionClass;

/**
 * オブジェクト操作ユーティリティ
 */
class ObjectHelper
{
    public function newInstanceFromString( $class )
    {
        if( is_object($class) ) return $class;
        $rc = new ReflectionClass( $class );
        return $rc->newInstanceArgs( array_slice(func_get_args(),1) );
    }
}

