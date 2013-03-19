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
namespace Nora\Controller;

use Nora\General\Helper;

/**
 * フロントコントローラ
 */
class FrontController implements FrontControllerIF
{
    use FrontControllerTrait;

    public function __construct( )
    {
        // ヘルパーブローカーをセットする
        $this->setHelperBroker( new Helper\Broker() );
    }

}
