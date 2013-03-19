アプリケーションパッケージャー
=======

ディレクトリ構成
--
	someapp/
		config/
			app_ini
		autoload/
			some_autotload.php
		src/
			Some/
				Class.php
		library/

モジュールの起動と初期化
--
	$app = new App( somename, someapp );
もしくは
	$factory = APP::getFactory( somename, someapp );
	$app = $factory( );

ファサードの設定
--
    $app->setFacade( $class );
    $app->facade( )->somemethod( );

