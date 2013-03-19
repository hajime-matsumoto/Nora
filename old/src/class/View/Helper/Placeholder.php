<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   View
 * @package    Helper
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\View\Helper;

/**
 * プレイスホルダヘルパー
 */
class Placeholder extends \ArrayObject implements HelperIF
{
    use HelperTrait;

    private $_prefix;
    private $_postfix;
    private $_format = "%s";
    private	$_separator = "";

    public function __call( $name, $args )
    {
        if( method_exists($this,"_".$name) )
        {
            call_user_func_array( array($this,"_".$name), $args );
            return $this;
        }
        if( is_callable('parent::__call') )
        {
            return parent::__call( $name, $args );
        }
        throw new \Exception( "call to undefined method $name" );
    }

    protected function _setPrefix( $val )
    {
        $this->_prefix = $val;
    }

    protected function _setPostfix( $val )
    {
        $this->_postfix = $val;
    }

    protected function _setFormat( $val )
    {
        $this->_format = $val;
    }

    protected function _setSeparator( $val )
    {
        $this->_separator = $val;
    }

    public function append( )
    {
        if( func_num_args() == 1 )
        {
            parent::append( func_get_arg(0) );
            return $this;
        }

        parent::append( func_get_args() );
        return $this;
    }

    protected function _capStart( )
    {
        ob_start();
    }

    protected function _capEnd( $name = null)
    {
        if( $name == null ) return $this->append( ob_get_clean() );
        $this[$name] = ob_get_clean();
    }


    public function placeholder( $name )
    {
        if( $this->offsetExists($name) ) return $this[$name];

        return $this[$name] = new Placeholder( );
    }

    public function toString( )
    {
        $text = $this->_prefix;

        $parts = array();
        foreach( $this as $v )
        {
            if(is_object($v))
            {
                $parts[] =(string) $v;
                continue;
            }

            if(is_array($v))
            {
                $parts[] = vsprintf( $this->_format, $v );
                continue;
            }

            if(is_string($v))
            {
                $parts[] = sprintf( $this->_format, $v );
            }
        }
        $text.= implode( $this->_separator, $parts );
        $text.= $this->_postfix;
        return $text;
    }
}



