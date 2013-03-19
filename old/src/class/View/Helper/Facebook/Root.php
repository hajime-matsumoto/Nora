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
namespace Nora\View\Helper\Facebook;

use Nora\View\Helper;

/**
 * ヘルパー: Github 
 */
class Root extends Helper\Placeholder
{
    protected $_dataLayout='button_count';
    protected $_dataWidth='450';
    protected $_dataAnnotation='bubble';
    protected $_format = '<div class="fb-like" data-send="true" data-layout=":dataLayout" data-width=":dataWidth" data-show-faces="true"></div>';
    private $_app_id;


    protected function _root( $app_id = null)
    {
        if( $app_id == null ) return;
        $this->_app_id = $app_id;
    }


    public function __toString( )
    {
        /*
            $this->getBrokerOwner( )->bodyScript()->appendCode('(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId='.$this->_app_id.'";fjs.parentNode.insertBefore(js, fjs); }(document, \'script\', \'facebook-jssdk\'));');
         */

        return '<div id="fb-root"></div>';
    }
}
