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
 * テンプレータ桁区切りヘルパー
 */
class Date implements Helper\HelperIF
{
    use Helper\HelperTrait;

    private $_fields = array();
    protected $format = "Y/m/d G:i:s";

    public function __construct()
    {
    }

    public function setFormat( $format )
    {
        $this->format = $format;
        return $this;
    }

    public function Date( $string = null)
    {
        if( $string == null ) return $this;

        if( !$time = strtotime($string) ) return $string;

        return date( $this->format, $time );
    }
}
