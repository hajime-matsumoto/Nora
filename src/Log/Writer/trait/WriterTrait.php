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
namespace Nora\Log\Writer;

use Nora\General;
use Nora\Log;

trait WriterTrait
{
    use General\SetupableTrait;

    private $_logger;
    private $_logs = array();
    private $_reporting_level = null;
    private $_reporting_category = null;
    private $logFormat = "%writer%:%category% %message% %datetime%";
    protected $name;

    public function setLogger( Log\LoggerIF $logger )
    {
        $this->_logger = $logger;
    }

    public function setReportingLevel( $input_level )
    {
        if( func_num_args() == 1 ) {
            $this->_reporting_level = $input_level;
            return $this;
        }

        $args = func_get_args();
        $level = array_pop($args);
        foreach( $args as $input_level )
        {
            $level = $level | $input_level;
        }
        $this->_reporting_level = $level;
        return $this;
    }

    public function getReportingLevel( )
    {
        return $this->_reporting_level;
    }

    public function setReportingCategory( $input_category )
    {
        $this->_reporting_category = func_get_args();
        return $this;
    }

    public function getReportingCategory( )
    {
        return $this->_reporting_category;
    }

    public function logging( $msg )
    {
        $this->_logs[] = $msg;
    }

    public function write( $level, $category, $params)
    {
        if( $this->_reporting_level !== null)
        {
            if($this->_reporting_level & $level ? false: true )
            {
                return;
            }
        }
        if( $this->_reporting_category !== null && !in_array($category,$this->_reporting_category))
            return;

        $params['writer'] = $this->name;

        $this->logging( $this->_logFormat($params) );
    }

    private function _logFormat( $params )
    {
        $string = $this->logFormat;

        foreach( $params as $k=>$v )
        {
            $string = str_replace("%{$k}%", $v, $string);
        }

        return $string;
    }

    public function flush( )
    {
        if(empty($this->_logs)) return;
        $this->_flush($this->_logs);

        $this->_logs = array();
    }
}
