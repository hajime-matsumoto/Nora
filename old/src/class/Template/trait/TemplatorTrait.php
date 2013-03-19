<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Template
 * @package    Templator
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Template;

trait TemplatorTrait
    {
        private $_template_file = '';
        private $_template_params = array();

        /**
         * テンプレートに値をアサイン
         */
        public function assign( $name, $value = null)
        {
            if( is_array( $name ) ) 
            {
                foreach( $name as $k=>$v )
                {
                    $this->assign($k, $v);
                }
                return;
            }
            $this->_template_params[$name] = $value;
        }

        /**
         * 使用するテンプレート名を設定する
         */
        public function setTemplateFile( $file )
        {
            $this->_template_file = $file;
        }


        /**
         * テンプレートを実行する
         */
        public function render( )
        {
            // パラメータを展開する
            foreach( $this->_template_params as $k=>$v )
            {
                $$k = $v;
            }

            // テンプレートを検索する
            ob_start();
            include $this->_template_file;
            return ob_get_clean();
        }

        public function renderTemplate( $tpl, $params )
        {
            foreach( $params as $k=>$v )
            {
                $$k = $v;
            }

            ob_start( );
            include $tpl;
            return ob_get_clean();
        }
    }
