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
interface ResponseIF extends \IteratorAggregate,\ArrayAccess,\Serializable,\Countable
{
    /**
     * Viewをセットする
     */
    public function setView( ViewIF $view );

    /**
     * テンプレートファイル名をセットする
     */
    public function setTemplateFile( $file );

    /**
     * テンプレートファイル名を取得する
     */
    public function getTemplateFile();

    /**
     * 描画
     */
    public function render( );
}
