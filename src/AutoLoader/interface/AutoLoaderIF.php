<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * オートローダクラスを定義する
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\AutoLoader;


/**
 * オートローダーインターフェイス
 */
interface AutoLoaderIF
{
    /**
     * シングルトンで使用する場合
     */
    static public function getInstance( );

    /**
     * オートロード対象になるネームスペースを設定
     * 第二引数は検索対象となるディレクトリ
     */
    public function addNamespace( $namespace, $dirctory );

    /**
     * 登録されているネームスペースを全件取得
     */
    public function getNamespaces( );


    /**
     * PHPのオートロードからのコールバック
     */
    public function __autoload( $name );
}
