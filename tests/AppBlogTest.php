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

// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';


class AppBlogTestCase extends PHPUnit_Framework_TestCase
{
    private $blog;

    public function setup( )
    {
        Nora\Nora::getInstance( );

        // ブログアプリを起動
        $this->blog = new Nora\Package\Module('blog', NORA_HOME.'/doc/examples/apps/blog');
    }

    /**
     * ブログを作成する
     */
    public function testCreateBlog( )
    {
        // ブログを作成する
        $response = $this->blog->reciveRequest('/blog/create', array(
            'id' => 'news',
            'title' => 'ニュース',
            'description' => 'ニュース'
        ));

        var_dump($response);
    }
}
