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
namespace Nora\Templator\Helper;

use Nora\General;
use Nora\General\Helper;

/**
 * テンプレータプレースホルダーヘルパー
 */
class Placeholder extends \ArrayObject implements Helper\HelperIF
{
    use Helper\HelperTrait;

    private $_fields = array();

    public function __construct()
    {
    }

    public function Placeholder( $name )
    {
        if( $this->offsetExists($name) ) return $this->offsetGet($name);

        return $this[$name] = new Placeholder();
    }

    public function fields()
    {
        $this->_fields = func_get_args();
        return $this;
    }

    public function add( )
    {
        parent::append( array_combine($this->_fields, func_get_args()) );
        return $this;
    }

    public function assign( )
    {
        parent::exchangeArray( array_combine($this->_fields, func_get_args()) );
        return $this;
    }

    public function __get($name)
    {
        return $this->offsetGet($name);
    }
}
