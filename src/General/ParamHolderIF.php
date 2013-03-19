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
namespace Nora\General;


/**
 * パラメータホルダー
 */
interface ParamHolderIF
{
    public function hasParam( $name );

    public function getParams( );

    public function getParam( $name, $default = false );

    public function setParams( $array );

    public function setParam( $name, $value );

    public function getParamsF( $format );
}
