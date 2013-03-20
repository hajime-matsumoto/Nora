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
 * setup( $settings ) 可能にする
 */
trait SetupableTrait
{
	public function setup( $name, $setting = null)
    {
        if( $setting == null && is_array($name ) ) {
            $setting = $name;
            foreach( $setting as $k=>$v ) {
                $this->setup($k,$v);
            }
            return $this;
        }

        if( !is_string($name) ) return $this;

        // setName系のメソッドがあればそちらへ
        if( method_exists( $this, $method = 'set'.$name ) )
        {
            call_user_func( array($this,$method), $setting );
            return $this;
        }

        // 同名プロパティが存在すれば代入
        if( property_exists( $this, $name ) )
        {
            $this->$name = $setting;
            return $this;
        }

        throw new SetupException(
            get_clasS($this)."->$name をセットアップできません。"
            ."プロパティ名が存在しないかメソッドset".ucfirst($name)."が存在しません。"
        );
    }
}

class SetupException extends \Exception{ }
