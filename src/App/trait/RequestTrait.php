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
namespace Nora\App;

use Nora\General;

/**
 * リクエスト基本機能
 */
trait RequestTrait
{
    use General\ParamHolderTrait;

    public function setVars( $datas )
    {
        foreach( $datas as $k=>$v )
        {
            $this->setVar( $k, $v );
        }
    }

    public function setVar( $k, $v )
    {
        $this[$k] = $v;
    }

    public function export()
    {
        $array = array(
            'params'=>$this->getParams(),
            'datas'=>$this->getArrayCopy()
        );

        return $array;
    }
}
