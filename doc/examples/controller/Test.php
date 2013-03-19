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
namespace NoraTest\Controller;

use Nora\Controller;

/**
 * コントローラー
 */
class Test extends Controller\ActionController
{
    public function indexAction( $response, $request )
	{
		$response['message'] = 'hello wild';
	}

	public function stdoutAction( $response, $request )
	{
		echo 'hello wild';
	}
}
