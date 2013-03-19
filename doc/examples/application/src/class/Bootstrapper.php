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
namespace NoraApplication;

use Nora\Application;

/**
 * ブートスラッパ
 */
class Bootstrapper extends Application\Bootstrapper
{

    public function _initRouter( $setting )
    {
        $router = parent::_initRouter( $setting );

        $router->addRoute(100, '/themes/:request_uri', array('module'=>'theme','controller'=>'static','action'=>'index'));
        $router->addRoute(999, ':request_uri', array('controller'=>'staticPublish','action'=>'index','request_uri'=>'index.html'));

        return $router;
    }

	public function _initView( $setting )
	{
        $view = parent::_initView( $setting );
        $view = $this->initComponent('view', $view );

		$view->headMeta( )->charset('utf8');
		$view->headMeta( )->name('keyword','test,nora,php,framework,国産');
		$view->headMeta( )->httpEquiv('content-type','text/html; charset=UTF-8');
		$view->headMeta( )->property('og:title','たいとる');

		$view->headMeta( )->twitter('card','summary');
		$view->headMeta( )->twitter('site','@hajime-mat');
		$view->headMeta( )->twitter('creater','@hajime-mat');
		$view->headMeta( )->twitter('url','http://dev.hazime.org/index.php');
		$view->headMeta( )->twitter('title','松本ハジメのWEBサイト');
		$view->headMeta( )->twitter('description','松本ハジメのWEBサイト');
		$view->headMeta( )->twitter('image','');

		$view->headMeta( )->og('site_name','松本ハジメのWEBサイト');
		$view->headMeta( )->og('title','松本ハジメのWEBサイト');
		$view->headMeta( )->og('description','松本ハジメのWEBサイト');
		$view->headMeta( )->og('url','http://dev.hazime.org/index.php');
		$view->headMeta( )->og('type','profile');
		$view->headMeta( )->og('image','profile');

		$view->headStyle( )->appendFile('/assets/css/reset.css');
		$view->headScript( )->appendFile('/assets/js/jQuery.js');
		$view->bodyScript( )->appendCode('alert("loaded");');
		$view->googleAnalytics('UA-37941501-1');

		return $view;
	}
}
