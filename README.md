のらプロジェクト
===


テスト
--
	phpunit --bootstrap src/bootstrap.php tests/


事前準備
---
# PHP UNITのインストール
	pear channel-discover pear.phpunit.de
	pear install pear.phpunit.de/PHPUnit

# Xdebug

	pecl install xdebug
	vi /etc/php5/mods-available/xdebug.ini

	zend_extension="/usr/lib/php5/20100525/xdebug.so"

	sudo ln -s  /etc/php5/mods-available/xdebug.ini  /etc/php5/conf.d/20-xdebug.ini

# ガバレッジレポート
	phpunit --coverage-html ./report nora

ドキュメントツールの使用法方
===

	pear install --alldeps phpdocumentor

	phpdoc -d nora/ -t ドキュメント

	pear config-set auto_discover 1
	pear install pear.apigen.org/apigen

	apigen --source library --exclude "*Zend*" --destination doc/apigen --title "Nora Project"
