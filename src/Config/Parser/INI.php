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
namespace Nora\Config\Parser;

use Nora\Config;

/**
 * INIパーサー
 */
class INI implements ParserIF
{
    const DEFAULT_SECTION = 'default';

    private $_parsed_section_map = array();
    private $_parsed_datas = array();
    private $_parsed_current_section = self::DEFAULT_SECTION;
    private $_parse_lines = array();

    /**
     * 解析する
     */
    static public function parse( $file, $section = self::DEFAULT_SECTION )
    {
        $string = file_get_contents( $file );

        $parser = new INI();
        $datas = $parser->parseString( $string , $section );
        return new Config\Config( $datas );
    }

    /**
     * 文字列から設定を読み込む
     */
    public function parseString( $string, $section = self::DEFAULT_SECTION )
    {
        if( empty($string) ) throw new CantParseNullException('文字列が空では解析できません' );

        $this->_parse_lines        = explode(PHP_EOL, $string );
        $this->_parseLines(  );

        // セクションのマージ処理
        $cur = $section;
        $datas= $this->_parsed_datas[$section];
        while( isset($this->_parsed_section_map[$cur]) )
        {
            $cur   = $this->_parsed_section_map[$cur];
            $datas = array_merge( $this->_parsed_datas[$cur], $datas);
        }
        return $datas;
    }

    private function _parseLines( )
    {
        // セクション情報をパースする
        foreach( $this->_parse_lines as $line )
        {
            if( empty($line) ) continue;
            if( $line{0} == '#' ) continue;

            if( $line{0} == '[' ) { 
                $this->_parseSectionLine( $line ); 
                continue;
            }

            $this->_parseDataLine( $line );
        }
    }

    private function _parseSectionLine( $line )
    {
        $line = trim($line,'[');
        $line = trim($line,']');
        $line = trim($line);

        $section = trim(strtok( $line, ':') );
        $this->_parsed_current_section = $section;
        if( $parent = trim(strtok( '' )) )
        {
            $this->_parsed_section_map[$section] = $parent;
            $this->_parsed_datas[$section] = array();
        }
    }

    private function _parseDataLine( $line )
    {
        $parts = explode('=', $line, 2);

        if(count($parts) != 2 ) continue;

        $key = trim($parts[0]);

        // 定数を使う
        $constants = get_defined_constants(true);
        $val = str_replace(
            array_keys($constants['user']),
            array_values($constants['user']),
            trim($parts[1])
        );

        $this->_parsed_datas[$this->_parsed_current_section][$key] = $val;
    }

}

class CantParseNullException extends \Exception
{

}
