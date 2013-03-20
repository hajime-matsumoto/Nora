<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 * テストファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, nora project all rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正bsdライセンス
 * @version    $id$
 */

namespace Nora\Package;

use Nora\AutoLoader\AutoLoader;
use Nora\General;
use Nora\General\Helper;
use Nora\Service;
use Nora\Bootstrap;
use Nora\Config\Config;
use Nora\Request;
use Nora\Response;

/**
 * パッケージインターフェイス
 */
interface PackageIF extends 
    General\ParamHolderIF
    ,Helper\HelperIF
    ,Helper\BrokerOwnerIF
    ,Service\InitializableIF
    ,Bootstrap\BootstrapperOwnerIF
    ,General\SetupableIF
{
    /**
     * ヘルパメソッド
     */
    public function package();

    /**
     * リクエストを作成する
     */
    public function makeRequest();

    /**
     * レスポンスを作成する
     */
    public function makeResponse();

    /**
     * 初期化処理
     *
     * コンフィグの作成
     * パッケージ名をパラメタに登録
     * ネームスペースとライブラリをオートローダに登録
     * Vendorをインクルードパスに追加する
     * ブートストラッパの組み込み
     * ヘルパブローカの組み込み
     */
    public function init();

    /**
     * パッケージライブラリからクラスを呼び出す
     */
    public function newInstance( $class_name );

    /**
     * コントローラがあるか
     */
    public function hasController( $ctrl_name );

    /**
     * コントロールアクションの実行
     */
    public function action( $ctrl_name, $act_name, Request\RequestIF $request = null, Response\ResponseIF $response = null );
}


