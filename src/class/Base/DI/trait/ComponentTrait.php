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
namespace Nora\Base\DI;

/**
 * コンポーネントの機能
 */
trait ComponentTrait
{
    use ContainerOwnerTrait;

    /**
     * コンポーネントをセットアップする
     */
    public function setup( $setting )
    {
        foreach( $setting as $k=>$v )
        {
            nora_load_util('class');

            // setHoge($v)を実行する
            if( nora_class_auto_call_prefixed_method($this,'set', $k, $v) ) continue;

            // setHogeが存在しない
            // かつオブジェクトにプロパティが存在すれば
            // 値を書き込む
            if( property_exists($this,$k) )
            {
                $this->$k = $v;
            }
        }
    }

    /**
     * コンポーネントをイニシャライズする
     */
    public function initialize( )
    {

    }
}
