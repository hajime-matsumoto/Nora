<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Controller
 * @package    View
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Controller;

/**
 * ビューインターフェイス
 */
trait ViewRendererTrait
{
    protected $view;
    protected $front;
    protected $suffix = '.tpl';

    /**
     * ビューをセットする
     */
    public function setView( $view )
    {
        $this->view = $view;
    }

    /**
     * フロントをセットする
     */
    public function setFront( $front )
    {
        $this->front = $front;
    }

    /**
     * 描画する
     */
    public function render( $response, $request )
    {
        $module     = $request->getModuleName();
        $controller = $request->getControllerName();
        $action     = $request->getActionName();

        $view_dir = $this->front->getModule($module)->getFilePath('/view');

        $view_file = '/script/'.$controller.'/'.$action;
        $view_file.= $this->suffix;

        $this->view->render( $view_file, $response, $view_dir );
    }
}
