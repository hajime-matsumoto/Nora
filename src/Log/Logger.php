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
namespace Nora\Log;

use Nora\General;
use Nora\Log\Writer;

define('NORA_LOG_DEBUG'   , 16);
define('NORA_LOG_NOTICE'  , 32);
define('NORA_LOG_INFO'    , 64);
define('NORA_LOG_WARNING' , 128);
define('NORA_LOG_ERROR'   , 256);
define('NORA_LOG_ALL'     , 511);

class Logger implements LoggerIF
{
    use General\SingletonTrait;

    private $_php_level_label_map;
    private $_php_level_map;
    private $_level_label_map;
    private $_log_writers = array();

    private function __construct()
    {
        $this->_initLevelMap();
    }

    private function _initLevelMap()
    {
        $this->_php_level_label_map = array(
            E_NOTICE             => 'E_NOTICE',
            E_ERROR             => 'E_ERROR',
            E_WARNING           => 'E_WARNING',
            E_PARSE             => 'E_PARSE',
            E_NOTICE            => 'E_NOTICE',
            E_CORE_ERROR        => 'E_CORE_ERROR',
            E_CORE_WARNING      => 'E_CORE_WARNING',
            E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
            E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
            E_USER_ERROR        => 'E_USER_ERROR',
            E_USER_WARNING      => 'E_USER_WARNING',
            E_USER_NOTICE       => 'E_USER_NOTICE',
            E_STRICT            => 'E_STRICT',
            E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
            E_DEPRECATED        => 'E_DEPRECATED',
            E_USER_DEPRECATED   => 'E_USER_DEPRECATED'
        );

        $this->_level_label_map = array(
            NORA_LOG_DEBUG   => 'NORA_DEBUG',
            NORA_LOG_NOTICE  => 'NORA_NOTICE',
            NORA_LOG_INFO    => 'NORA_INFO',
            NORA_LOG_WARNING => 'NORA_WARNING',
            NORA_LOG_ERROR   => 'NORA_ERROR',
        );

        $this->_php_level_map = array(
            E_NOTICE             => NORA_LOG_NOTICE,
            E_ERROR             => NORA_LOG_ERROR,
            E_WARNING           => NORA_LOG_WARNING,
            E_PARSE             => NORA_LOG_ERROR,
            E_NOTICE            => NORA_LOG_NOTICE,
            E_CORE_ERROR        => NORA_LOG_ERROR,
            E_CORE_WARNING      => NORA_LOG_WARNING,
            E_COMPILE_ERROR     => NORA_LOG_ERROR,
            E_COMPILE_WARNING   => NORA_LOG_WARNING,
            E_USER_ERROR        => NORA_LOG_ERROR,
            E_USER_WARNING      => NORA_LOG_WARNING,
            E_USER_NOTICE       => NORA_LOG_NOTICE,
            E_STRICT            => NORA_LOG_NOTICE,
            E_RECOVERABLE_ERROR => NORA_LOG_ERROR,
            E_DEPRECATED        => NORA_LOG_ERROR,
            E_USER_DEPRECATED   => NORA_LOG_ERROR
        );
    }

    public function register()
    {
        set_error_handler(array($this,'phpErrorHandlerAdapter'));
        set_exception_handler(array($this,'phpExceptionHandlerAdapter'));
        // エラー終了時にもログをトリガする
        register_shutdown_function(array($this,'phpShutdownFunction'));
    }

    public function phpShutdownFunction()
    {
        $error = error_get_last();
        if( !$error ) {
            return $this->flush();
        }
        $this->phpErrorHandlerAdapter( 
            $error['type'],
            $error['message'],
            $error['file'],
            $error['line']
        );
        $this->flush();
    }

    public function flush()
    {
        foreach( $this->_log_writers as $writer )
        {
            $writer->flush();
        }
    }

    public static function phpErrorHandlerAdapter( $errno, $errstr, $errfile, $errline )
    {
        static::getInstance()->convPHPErrorNo($errno, $level, $label);
        static::getInstance()->write( $level, $label, $errstr . "(in $errfile,$errline)" );
    }

    public function convPHPErrorNo( $errno, &$level, &$label )
    {
        $label = isset($this->_php_level_label_map[$errno]) ?
            $this->_php_level_label_map[$errno]:
            "E($errno)";
        $level = isset($this->_php_level_map[$errno]) ?
            $this->_php_level_map[$errno]:
            NORA_LOG_ERROR;
    }

    public function phpExceptionHandlerAdapter( $exception )
    {
        $this->write( NORA_LOG_ERROR, 'EXCEPTION', $exception->getMessage() );
    }

    #--- ログライター系の処理 --#

    public function atachLogWriter( Writer\WriterIF $writer )
    {
        $writer->setLogger( $this );
        $this->_log_writers[] = $writer;
    }

    public function write( $level, $label, $message )
    {
        // ライターに渡すパラメタを作成する
        $params['level'] = $level;
        $params['category'] = ($label) ?$label: $this->_level_label_map($level);
        $params['message'] = $message;
        $params['datetime'] = date("ymd H:i:s");
        foreach( $this->_log_writers as $writer )
        {
            $writer->write( $level, $label, $params );
        }
    }
    public function reset(){
        $this->_log_writers = array();
    }
}
