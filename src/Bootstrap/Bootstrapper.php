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
namespace Nora\Bootstrap;

use Nora\Service;
use Nora\Controller;

/**
 * ブートストラッパ
 */
class Bootstrapper implements BootstrapperIF
{
    use BootstrapperTrait;

    public function __construct( )
    {
        $this->initMethodFactory( );
    }
}
