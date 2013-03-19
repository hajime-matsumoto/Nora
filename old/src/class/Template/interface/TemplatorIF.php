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

interface TemplatorIF
{
    /**
     * テンプレートに値をアサイン
     */
    public function assign( $name, $value = null);

    /**
     * 使用するテンプレート名を設定する
     */
    public function setTemplateFile( $file );

    /**
     * テンプレートを実行する
     */
    public function render( );
}
