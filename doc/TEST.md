テストツールの使用方法
===

事前準備
---

# PHP UNITのインストール
	pear channel-discover pear.phpunit.de
	pear install pear.phpunit.de/PHPUnit

# Xdebug

	pecl install xdebug
	vi /etc/php5/mods-available/xdebug.ini
>zend_extension="/usr/lib/php5/20100525/xdebug.so"
	sudo ln -s  /etc/php5/mods-available/xdebug.ini  /etc/php5/conf.d/20-xdebug.ini

# ガバレッジレポート
phpunit --coverage-html ./report nora
