<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Service;


require_once 'Service/interface/ManagerOwnerIF.php';

/**
 * サービスマネージャーインターフェイス
 */
interface ManagerIF extends ManagerOwnerIF
{
    /**
     * タイプをフォーマットする
     */
    public function formatType( $unformated_type );

    /**
     * サービス名をフォーマットする
     */
    public function formatName( $unformated_name );

    /**
     * コンポーネントショートハンド:put
     */
    public function putComponent( $unformated_name, $factory, $setting = array());

    /**
     * コンポーネントショートハンド:pull
     */
    public function pullComponent( $unformated_name );


    /**
     * サービスを設置する
     */
    public function putService( $unformated_type, $unformated_name, $factory, $setting = array() );

    /**
     * サービスディレクトリを設置する
     */
    public function putServiceDir( $unformated_type, $dir_name, $prefix, $sufix = null );

    /**
     * サービスを登録する
     */
    public function registerService( $unformated_type, $unformated_name, $service );

    /**
     * サービスのファクトリを登録する
     */
    public function registerServiceFactory( $unformated_type, $unformated_name, $factory, $setting = array() );


    /**
     * サービスを取得する
     *
     * @exception ServiceNotFoundException
     */
    public function pullService( $unformated_type, $unformated_name );

    /**
     * サービスが存在するか
     */
    public function hasService( $unformated_type, $unformated_name );

    /**
     * サービスを取得
     */
    public function getService( $unformated_type, $unformated_name );

    /**
     * ファクトリを取得
     */
    public function getServiceFactory( $unformated_type, $unformated_name );

    /**
     * ファクトリ設定値を取得
     */
    public function setServiceSetting( $unformated_type, $unformated_name, $array );

    /**
     * ファクトリ設定値を取得
     */
    public function getServiceSetting( $unformated_type, $unformated_name);
    /**
     * サービスを作成
     */
    public function createService( $unformated_type, $unformated_name );

    /**
     * サービスを削除
     */
    public function removeService( $unformated_type, $unformated_name );

    /**
     * サービスが初期化されているか
     */
    public function isInitialized( $unformated_type, $unformated_name );

    /**
     * サービスの初期化
     */
    public function initialize( $unformated_type, $unformated_name, $service );

    /**
     * サービスがレジストされているか
     */
    public function isServiceRegistered( $unformated_type, $unformated_name );

    /**
     * サービスファクトリがレジストされているか
     */
    public function isServiceFactoryRegistered( $unformated_type, $unformated_name );
}
