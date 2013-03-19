<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Application
 * @package    Application
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Application;

/**
 * アプリケーションクラス
 */
class Application implements ApplicationIF
{
    use ApplicationTrait;

    public function run( )
    {
        $params = $this->bootstrap('router')->routeURI(
            $this->bootstrap('request')->getRequestURI()
        );

        $this->bootstrap('frontController')->run( $params );
    }
}
