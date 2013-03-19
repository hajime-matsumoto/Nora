<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   View
 * @package    Response
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\View;

/**
 * ビュー用のレスポンス
 */
trait ResponseTrait
{
    private $_template_file;
    private $_view;

    public function setView( ViewIF $view )
    {
        $this->_view = $view;
    }

    public function setTemplateFile( $file )
    {
        $this->_template_file = $file;
    }

    public function getTemplateFile()
    {
        return $this->_template_file;
    }

    public function render( )
    {
        return $this->_view->renderResponse( $this );
    }
}
