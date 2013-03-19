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

use Nora\General\Helper;

/**
 * ヘルパー機能
 */
trait HelperTrait
{
    use Helper\HelperTrait;

    public function __toString( )
    {
        return (string) $this->toString();
    }
}
