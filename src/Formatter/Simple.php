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
namespace Nora\Formatter;

use Nora\General;

class Simple
{
    use General\SetupableTrait;

    protected $keyStart = "%";
    protected $keyEnd = "%";

    public function format( $string, $params )
    {
        foreach( $params as $k=>$v )
        {
            $string = str_replace($this->keyStart.$k.$this->keyEnd, $v, $string);
        }
        return $string;
    }
}
