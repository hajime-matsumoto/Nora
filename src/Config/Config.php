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
namespace Nora\Config;

use Nora\General\Helper;

/**
 * コンフィグコンテナ
 */
class Config extends \ArrayObject implements Helper\HelperIF
{
    use Helper\HelperTrait;

    public function __construct( $datas = null)
    {
        if( $datas == null ) return;
        $this->import( $datas );
    }

    public function config( $key = null, $default = null )
    {
        if( $key == null ) return $this;
        return $this->getConf( $key, $default );
    }

    public function sprintf( $format )
    {
        if( func_num_args() < 2 ) return $format;
        for($i=1;$i<func_num_args();$i++){
            $args[] = $this->getConf(func_get_arg($i));
        }
        return vsprintf( $format, $args );
    }



    /**
     * インポート
     */
    public function import( $mixed )
    {
        foreach( $mixed as $k=>$v )
        {
            $this->setConf( $k, $v );
        }
    }

    /**
     * インポートINI
     */
    public function importINIFile( $file_path, $section = null)
    {
        $parsed_vars = \Nora\Parser\INI::parse( $file_path, $section );
        $this->import( $parsed_vars );
    }


    /**
     * 設定値を登録する
     */
    public function setConf( $name, $value )
    {
        if( strpos($name,'.') ) return $this->_parseSet( $name, $value );
        $this[$name]=$value;
    }

    /**
     * 設定値を確認する
     */
    public function hasConf( $name )
    {
        if( strpos($name,'.') ) return $this->_parseHas( $name );
        if( !$this->offsetExists( $name ) ) return false;
        return true;
    }


    /**
     * 設定値を取得する
     */
    public function getConf( $name, $default = false )
    {
        if( strpos($name,'.') ) return $this->_parseGet( $name, $default );
        if( !$this->offsetExists( $name ) ) return $default;
        return $this[$name];
    }

    /**
     * ドット入りの名前を解決して、値を登録する
     */
    private function _parseSet( $name, $value )
    {
        $parent_key = strtok($name, '.');
        $cur =& $this;
        while( $key = strtok('.') )
        {
            if( !isset($cur[$parent_key]) )
            {
                $cur[$parent_key] = array();
            }
            $cur =& $cur[$parent_key];
            $parent_key = $key;
        }
        $cur[$parent_key] = $value;
    }

    /**
     * ドット入りの名前を解決して、値を取得する
     */
    private function _parseGet( $name, $default )
    {
        $parent_key = strtok($name, '.');
        $cur =& $this;
        while( $key = strtok('.') )
        {
            if( !isset($cur[$parent_key]) ) return $default;
            $cur =& $cur[$parent_key];
            $parent_key = $key;
        }
        if(!isset($cur[$parent_key])) return  $default;
        return $cur[$parent_key];
    }
    /**
     * ドット入りの名前を解決して、値があるか確認する
     */
    private function _parseHas( $name )
    {
        $parent_key = strtok($name, '.');
        $cur =& $this;
        while( $key = strtok('.') )
        {
            if( !isset($cur[$parent_key]) ) return false;
            $cur =& $cur[$parent_key];
            $parent_key = $key;
        }
        if(!isset($cur[$parent_key])) return false;
        return true;
    }
}
