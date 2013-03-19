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
class Keta implements Helper\HelperIF
{
    use Helper\HelperTrait;

    private $_fields = array();

    public function __construct()
    {
    }

    public function Keta( $string )
    {
        return number_format( $string );
    }
}
