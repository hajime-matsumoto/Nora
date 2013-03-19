<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @category   General
 * @package    AutoProp
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\General;

/**
 * オブジェクトのプロパティ操作を自動にする
 */
trait AutoProp
    {
        protected function autoPropRealName( $name )
        {
            $name = lcfirst($name);
            if(!property_exists( $this, $name )) return false;
            return $name;
        }

        public function __call( $name, $args )
        {
            $prefix = substr($name,0,3);
            if( !in_array($prefix,array('set','get','add')) ) return;
            if( !$real_name = $this->autoPropRealName(substr($name,3))) return;

            array_unshift($args, $real_name );
            return call_user_func_array( array($this,'autoProp'.ucfirst($prefix)),$args );
        }

        public function autoPropSet( $name, $value )
        {
            $this->$name = $value;
            return $this;
        }

        public function autoPropGet( $name )
        {
            return $this->$name;
        }

        public function autoPropAdd( $name, $value )
        {
            if( !is_array($this->$name) )
            {
                $this->$name = array($name);
                return $this;
            }
            array_push( $this->$name, $value );
            return $this;
        }
    }
