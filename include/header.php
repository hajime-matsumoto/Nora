<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 * のらライブラリを使用する場合
 * 必ず、このスクリプトをインクルードする
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

// のらコア取得
require_once dirname(__FILE__).'/../library/Nora/Core/Nora.php';

/** のらインスタンス取得のショートハンド */
function Nora( )
{
	return Nora\Core\Nora::getInstance( );
}

// インスタンスの初期化
Nora();
