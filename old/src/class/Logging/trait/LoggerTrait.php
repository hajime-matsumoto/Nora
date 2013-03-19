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
namespace Nora\Logging;

use Nora\Base\DI;

/**
 * ロガーの機能
 */
trait LoggerTrait
{
    /**
     * ログフォーマット
     */
    protected $logFormat = '[:label] [:name] :time :message';

    /**
     * タイムフォーマット
     */
    protected $timeFormat = 'Y-m-d G:i:s';

    /**
     * レポーティングレベル
     */
    protected $reportingLevel = self::E_ALL;

    /**
     * ロガーネーム
     */
    protected $loggerName = 'SYSTEM';

    /**
     * レベルラベルを取得
     */
    public function leveltolabel( $level )
    {
        switch( $level )
        {
        case self::E_DEBUG:
            return 'debug';
        case self::E_NOTICE:
            return 'notice';
        case self::E_WARNING:
            return 'warning';
        case self::E_ERROR:
            return 'error';
        }
        return 'unknown';
    }

    /**
     * レポーティングレベルを設定、もしくは取得する
     */
    public function reportingLevel( $level = null )
    {
        if($level == null) return $this->reportingLevel;
        $this->reportingLevel = $level;
    }

    public function setReportingLevel( $level )
    {
        return $this->reportingLevel($level);
    }

    /**
     * ログを記録する
     *
     * @param init レベル
     * @param string メッセージもしくは%sを含むフォーマット文
     * @param パラメータ [...]
     */
    public function logging( $level, $message )
    {
        $_is_reporting = $this->reportingLevel( ) & $level;
        if( !$_is_reporting ) return;

        if(func_num_args() > 2)
        {
            $message = vsprintf($message, array_slice(func_get_args(),2));
        }

        // フォーマット用のパラメータ
        $params['level'] = $level;
        $params['label'] = $this->leveltolabel($level);
        $params['time'] = date($this->timeFormat);
        $params['message'] = $message;
        $params['name'] = $this->loggerName;

        nora_load_util('array');
        $message = nora_array_format( $this->logFormat, $params );

        // 実際にロギングを実行する
        $this->loggingReal( $message, $params );
    }

    /**
     * ログを記録する
     */
    public function loggingArray( $level, $args )
    {
        // debug,noticeなどのメソッドから呼ばれた場合
        if( is_array($args[0]) ) $args = $args[0];

        array_unshift($args,$level);
        return call_user_func_array(array($this,'logging'), $args );
    }

    /**
     * デバッグメッセージをロギングする
     */
    public function debug( )
    {
        return $this->loggingArray(self::E_DEBUG,func_get_args());
    }

    /**
     * ノーティスメッセージをロギングする
     */
    public function notice( )
    {
        return $this->loggingArray(self::E_NOTICE,func_get_args());
    }

    /**
     * 警告メッセージをロギングする
     */
    public function warn( )
    {
        return $this->loggingArray(self::E_WARNING,func_get_args());
    }

    /**
     * エラーメッセージをロギングする
     */
    public function error( )
    {
        return $this->loggingArray(self::E_ERROR,func_get_args());
    }
}
