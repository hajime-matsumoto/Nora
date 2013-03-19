<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   NoraApplication
 * @package    Controller
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace NoraApplication\Controller;

use Nora\Controller;

/**
 * コントローラー
 */
class Home implements Controller\ControllerIF
{
    use Controller\ControllerTrait;

    public function indexAction( $req, $res )
    {
        $res['message'] = 'ようこそ、のらフレームワーク';
        return 'success';
    }
}
