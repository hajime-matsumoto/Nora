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
namespace NoraApp\Blog\Api;

use Nora\Controller;

/**
 * コントローラー
 */
class Blog extends Controller\ActionController
{
    public function indexAction( $response, $request )
	{
		$response['message'] = 'hello wild';
	}

	public function createAction( $response, $request )
    {
        $response->capEnd();

        $id          = $request['id'];
        $title       = $request['title'];
        $description = $request['description'];

        var_dump($this->helper('bootstrapper')->getServiceManager());


	}
}
