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
namespace Nora\View\Helper\Github;

use Nora\View\Helper;

/**
 * ヘルパー: Github 
 */
class Forkme extends Helper\Placeholder
{
    private $_img_table = array(
        'right'=>array(
            'red'=>'forkme_right_red_aa0000.png',
            'green'=>'forkme_right_green_007200.png',
            'darkblue'=>'forkme_right_darkblue_121621.png',
            'orange'=>'forkme_right_orange_ff7600.png',
            'gray'=>'forkme_right_gray_6d6d6d.png',
            'white'=>'forkme_right_white_ffffff.png'
        ),
        'left'=>array(
            'red'=>'forkme_left_red_aa0000.png',
            'green'=>'forkme_left_green_007200.png',
            'darkblue'=>'forkme_left_darkblue_121621.png',
            'orange'=>'forkme_left_orange_ff7600.png',
            'gray'=>'forkme_left_gray_6d6d6d.png',
            'white'=>'forkme_left_white_ffffff.png'
        )
    );
    private $_position = 'left'; // or right
    private $_color = 'red'; // or green,darkblue,orange,gray,white
    private $_alt = 'Fork me on GitHub';
    private $_path;
    private $_top = 0;

    private $_email, $_size = 200, $_default = 'mm';

    /** ダイレクトメソッド */
    protected function _forkme( $path = null )
    {
        if( $path == null ) return;
        $this->_path = $path;
    }

    protected function _setPosition( $position )
    {
        $this->_position = $position;
    }

    protected function _setColor( $color )
    {
        $this->_color = $color;
    }

    protected function _setTop( $top )
    {
        $this->_top = $top;
    }


    public function __toString( )
    {
        return sprintf(
            '<a href="https://github.com/%s">'.
            '<img '.
            'style="position: absolute; top: %s; %s: 0; border: 0;"'.
            'src="https://s3.amazonaws.com/github/ribbons/%s" alt="%s"></a>'
            ,
            $this->_path,
            $this->_top,
            $this->_position,
            $this->_img_table[$this->_position][$this->_color],
            $this->_alt
        );
    }
}
