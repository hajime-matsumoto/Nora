のらテスト
=======

ライブラリのテストスイートです。

テストスイートとは
--
	$ phpunit test/nora 

test/nora以下の`*text.php`を全て実行する機能。

	$ phpunit test/nora/Core などとして実行するテストを絞り込む事が可能

library/
	Core
		/Nora.php

test/
	nora
		Core/
			NoraTest.php

というディレクトリ構成にするとわかりやすい。
