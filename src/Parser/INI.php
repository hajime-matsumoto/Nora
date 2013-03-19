<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクトファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, nora project all rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正bsdライセンス
 * @version    $id$
 */
namespace Nora\Parser;

class INI
{
    const DEFAULT_SECTION = 'default';

    private $_parsed_section_map = array();
    private $_parsed_datas = array();
    private $_parsed_current_section = self::DEFAULT_SECTION;

    private $_is_section_enable = true;

    /**
     * 解析する
     */
    static public function parse( $file_name, $section = null )
    {
        $parser = new INI();
        return $parser->parseFile( $file_name, $section );
    }

    public function parseFile( $file_name, $section = null )
    {
        if( !file_exists($file_name) ) throw new FileNotFoundException($file_name);

        $string = file_get_contents( $file_name );
        return $this->parseString( $string, $section );
    }

    public function parseString( $string, $section = null )
    {
        if( $section == null ) $this->_is_section_enable = false;

        $this->_parseLines( explode(PHP_EOL, $string ) );

        // セクションを使用しなければ全データを展開
        $datas= array();
        if( !$this->_is_section_enable ){
            foreach( $this->_parsed_datas as $k=>$v ){
                $datas=array_merge($datas,$v);
            }
            return $datas;
        }

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

    private function _parseLines( $lines )
    {
        foreach( $lines as $line )
        {
            // 空行は無視
            if( empty($line) ) continue;
            // ＃から始まる行はコメント
            if( $line{0} == '#' ) continue;
            // [ から始まる行はセクション
            if( $line{0} == '[' ) { 
                $this->_parseSectionLine( $line ); 
                continue;
            }

            // それ以外はデータライン
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

class FileNotFoundException extends \Exception{}
