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
namespace Nora\General\Helper;


/**
 * ヘルパブローカー用の機能
 */
trait BrokerOwnerShortHandTrait
{
    public function __call( $name, $args )
    {
        return $this->helper($name)->invokeArgs($args);
    }
}

