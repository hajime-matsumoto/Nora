<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\General\Helper;

/**
 * ヘルパーブローカ
 */
interface BrokerIF
{
    /**
     * オーナーを設定する
     */
    public function setOwner( $owner );

    /**
     * オーナーを取得する
     */
    public function getOwner(  );

    /**
     * ヘルパブローカディレクトリを追加する
     */
    public function addHelperDirectory( $directory, $namespace, $name_prefix = '' );

    /**
     * ヘルパを追加する
     */
    public function addHelper( $name, $class );

    /**
     * ヘルパを取得する
     */
    public function pullHelper( $name );

    /**
     * ヘルパがあるか
     */
    public function hasHelper( $name );

    /**
     * ヘルパをコールする
     */
    public function invokeHelper( $name, $args );
}
