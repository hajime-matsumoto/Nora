<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Config
 * @package    Config
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Config;

use Nora\Logging;

/**
 * コンフィグ
 */
class ConfigINI extends \ArrayObject implements ConfigIF
{
    use ConfigTrait;
    use Logging\LoggingTrait;


    /**
     * ファイルから設定を読み込む
     */
    public function load( $file_name, $section = 'default' )
    {
        if( !file_exists($file_name) ) return $this->error('Can not load %s', $file_name);
        $this->loadString( file_get_contents($file_name), $section );
    }

    /**
     * 文字列から設定を読み込む
     */
    public function loadString( $string, $section )
    {
        if( empty($string) ) return;

        $parse_section_map = array( );
        $lines              = explode(PHP_EOL, $string );
        $section            = 'default';
        $datas              = array();

        foreach( $lines as $line )
        {
            if( empty($line) ) continue;
            if( $line{0} == '#' ) continue;
            if( $line{0} == '[' )
            {
                $parent_section = false;
                $this->_parseSection( $line, $section, $parent_section );
                $parse_section_map[$section] = $parent_section;
                $datas[$section] = array();
                continue;
            }

            $parts = explode('=', $line, 2);
            if(count($parts) != 2 ) continue;

            // 定数を使う
            $constants = get_defined_constants(true);

            $val = str_replace(
                array_keys($constants['user']),
                array_values($constants['user']),
                trim($parts[1])
            );
            $datas[$section][trim($parts[0])] = is_numeric($val) ? intval($val): $val;
        }


        // 継承関係を解決する ( name : parent )
        foreach( $parse_section_map as $k=>$v )
        {
            if( $v == false ) continue;
            $datas[$k] = array_merge($datas[$v], $datas[$k]);
        }

        // 設定を登録する
        foreach( $datas[$section] as $k=>$v )
        {
            $this->setConfig( $k, $v );
        }
    }

    /**
     * 設定を追加する
     */
    public function setConfig( $name, $value )
    {
        if( strpos($name,'.') ) return $this->_parseSet( $name, $value );
        $this[$name] = $value;
        return $this;
    }

    /**
     * 設定を取得する
     */
    public function getConfig( $name, $default = false)
    {
        if( strpos($name,'.') ) return $this->_parseGet( $name, $default );
        if( !$this->offsetExists( $name ) ) return $default;
        return $this->offsetGet( $name );
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
     * セクション情報をパースする
     */
    private function _parseSection( $line, &$section, &$parent_section )
    {
        if( !$part = trim(strtok(substr($line,1),']')) ) return;

        $parts = explode(':', $part);

        if( count($parts) == 1 )
        {
            $section = $part;
            return;
        }

        $section        = trim($parts[0]);
        $parent_section = trim($parts[1]);
        return;
    }
}
