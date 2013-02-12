機能を作るリスト
======



のらパッケージ
=====
エキストラのパッケージ
例えば、asteriskの機能など、
一般的でない機能は機能ごとパッケージとして封印する

# 例
	/nora/
			library
			...
			package/
						 asteisk/
										 library/


# 規約

パッケージはネームスペースを持つ

# 例
	Nora\Package\Asterisk

パッケージの組み込みをすると

# 例
	# 実態
	Nora::getLibraryLoader( )->addSearchPath( NORA_HOME."/package/ateisk", "Nora\\Packag\\Asterisk\\" );
	# ショートハンド
	Nora::getPackageManager( )->addPackage( NORA_HOME."/package/ateisk", "Nora\\Packae\\Asterisk\\" );


レゴブロックの発想
====

モジュール

Nora::DI
	Bootstrap::DI
		Modules::DI

というように入れ子にしてゆく


ログインモジュール
	NoraBootstrap('modules')->user->loginForm()

	NoraModule('user')->loginForm();

	NoraBootstrap('modules')->setModule(
		'user'=>array(
			'class'=> 'Modules\User' # Nora\Moduleを継承する
		)
	);

棲み分け
Nora::DI グローバルな設定
Nora::Bootstrapアプリケーション
Nora::Bootstratp以降に呼び出されるものはbootstrapを内包する


平行に使用する
Web  ------┐
User ----------- DB
