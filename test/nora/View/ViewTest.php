<?php
/*
 * のらテスト
 *---------------------- 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';


require_once dirname(__FILE__).'/../../../include/header.php';
use Nora\Core\Nora;

class ViewTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		Nora::init();
		Nora::getInstance()
			->bootstrap
			->addComponent('View', 'Nora\View\Component', array(
				'viewDir' => NORA_HOME.'/doc/sample/view'
			));
	}

	public function testViewInstance( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$this->assertInstanceOf( '\Nora\View\View', $view );
	}

	public function testPlaceholder( )
	{
		$view = Nora::getInstance()->bootstrap->view;

		// Placeholderを取得する
		$this->assertInstanceOf('Nora\View\Helper\Placeholder', $view->placeholder('test') );

		// データを追加する
		$view->placeholder('test')->append('abc')->append('def');
		$this->assertEquals('abcdef',(string) $view->placeholder('test'));

		// Formatを指定する
		$view->placeholder('test')->setFormat('<small>%s</small>');
		$this->assertEquals('<small>abc</small><small>def</small>', (string) $view->placeholder('test'));

		// PrefixとPostfixを指定する
		$view->placeholder('test')->setPrefix('<i>')->setPostfix('</i>');
		$this->assertEquals('<i><small>abc</small><small>def</small></i>', (string) $view->placeholder('test') );

		// 名前付きデータを指定する
		$view->placeholder('test')->hoge = 'xyz';
		$this->assertEquals('<i><small>abc</small><small>def</small><small>xyz</small></i>', (string) $view->placeholder('test') );
	}

	public function testPlaceholderArray( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$view->placeholder('table')->setPrefix('<table>')->setPostfix('</table>')->setFormat('<tr><td>%s</td><td>%s</td></tr>');
		$view->placeholder('table')->append(array('name','hajime'))->append(array('tel','033333333'));
		$this->assertEquals('<table><tr><td>name</td><td>hajime</td></tr><tr><td>tel</td><td>033333333</td></tr></table>', (string) $view->placeholder('table'));
	}

	public function testDoctype( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$this->assertInstanceOf('\Nora\View\Helper\Doctype', $view->doctype);
		$this->assertEquals('<!DOCTYPE html>'.PHP_EOL, (string) $view->doctype('html5'));
	}

	public function testGravator( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$this->assertInstanceOf('\Nora\View\Helper\Gravatar', $view->Gravatar);
		$this->assertEquals(
			'http://www.gravatar.com/avatar/414fc9b1b00ad29fda1d22690693c42d?s=200&d=mm',
			(string)$view->gravatar('mail@hazime.org')
		);
	}

	public function testHeadLink( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$this->assertInstanceOf('\Nora\View\Helper\HeadLink', $view->HeadLink);
		$view->HeadLink('StyleSheet','/assets/css/base.css','screen','text/css');
		$view->HeadLink('StyleSheet','/assets/css/default.css','screen','text/css');
		$this->assertEquals(
			"<link rel=\"StyleSheet\" href=\"/assets/css/base.css\" media=\"screen\" type=\"text/css\" />\n<link rel=\"StyleSheet\" href=\"/assets/css/default.css\" media=\"screen\" type=\"text/css\" />\n",
			(string) $view->HeadLink);
	}

	public function testHeadMeta( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$this->assertInstanceOf('\Nora\View\Helper\HeadMeta', $view->HeadMeta);

		// <meta name系
		$view->HeadMeta( )->appendName('keyword','hajime,matsumoto,hp');
		$this->assertEquals('<meta name="keyword" content="hajime,matsumoto,hp">'.PHP_EOL, (string) $view->HeadMeta() );
		// <meta http-equiv系
		$view->HeadMeta()->appendHttpEquiv('content-type','text/html; charset=utf-8','http-equiv');
		$this->assertEquals(
			"<meta name=\"keyword\" content=\"hajime,matsumoto,hp\">\n<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">\n"
			,(string) $view->HeadMeta
		);
		// <meta property系
		$view->HeadMeta()->setProperty('og:title','Facebook用のタイトル');
		$this->assertEquals(
			"<meta name=\"keyword\" content=\"hajime,matsumoto,hp\">\n<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">\n".
			'<meta property="og:title" content="Facebook用のタイトル">'.PHP_EOL
			,(string) $view->HeadMeta
		);
		// <meta charset系
		$view->HeadMeta()->setCharset('utf-8');
		$this->assertEquals(
			'<meta charset="utf-8">'.PHP_EOL.
			"<meta name=\"keyword\" content=\"hajime,matsumoto,hp\">\n<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">\n".
			'<meta property="og:title" content="Facebook用のタイトル">'.PHP_EOL
			,(string) $view->HeadMeta
		);
	}


	public function testHeadScript( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$this->assertInstanceOf('\Nora\View\Helper\HeadScript', $view->HeadScript);
		$view->HeadScript('window.onload = function(){ alert("hi"); };');
		$this->assertEquals(
			"<script type=\"text/javascript\" charset=\"utf-8\" language=\"javascript\">\nwindow.onload = function(){ alert(\"hi\"); };\n</script>",
			(string) $view->HeadScript()
		);
		$view->HeadScript( )->appendFile('/assets/js/jQuery.js');
		$this->assertEquals(
			'<script type="text/javascript" charset="utf-8" language="javascript" src="/assets/js/jQuery.js"></script>'
			.PHP_EOL
			."<script type=\"text/javascript\" charset=\"utf-8\" language=\"javascript\">\nwindow.onload = function(){ alert(\"hi\"); };\n</script>",
			(string) $view->HeadScript()
		);

		// FootScriptはHeadScriptのエイリアス
		$this->assertInstanceOf('\Nora\View\Helper\HeadScript', $view->FootScript);
	}

	public function testHeadTitle( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$this->assertInstanceOf('\Nora\View\Helper\HeadTitle', $view->HeadTitle);
		$view->HeadTitle('サイト名')->prepend('カテゴリ名')->prepend('ページ名');
	}

	public function testGithub()
	{
		$view = Nora::getInstance()->bootstrap->view;
		$this->assertInstanceOf('\Nora\View\Helper\GithubForkMe', $view->GithubForkMe);
		$this->assertEquals(
			"<a href=\"https://github.com/hajime-matsumoto/nora\"><img style=\"position: absolute; top: 0; left: 0; border: 0;\"src=\"https://s3.amazonaws.com/github/ribbons/forkme_left_red_aa0000.png\" alt=\"Fork me on GitHub\"></a>",
			(string) $view->GithubForkMe('hajime-matsumoto/nora')
		);
	}
	public function testTipicalView( )
	{
		// 良くありそうなパターン
		$view = Nora::getInstance()->bootstrap->view;
		// ヘルパーブローカを初期化
		$view->getHelperBroker( )->clearInstance();

		$view->headTitle('サイト名')->setSeparator('&midledot;');

		// View Script
		$view_script = <<<EOF
<?=\$view->Doctype('html5');?>
<html>
<head>
<?=\$view->headMeta()->setCharset('utf-8');?>
<?=\$view->headTitle('トップ');?>
</head>
<body>
<h1>たいとる</h1>
</body>
</html>
EOF;

		ob_start();
		$view->evaluation( $view_script );
		$data = ob_get_contents();
		ob_end_clean();
		$this->assertEquals(
			"<!DOCTYPE html>\n<html>\n<head>\n<meta charset=\"utf-8\">\n<title>トップ&midledot;サイト名</title></head>\n<body>\n<h1>たいとる</h1>\n</body>\n</html>",
			$data
		);
	}

	public function testSearchViewFile( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$file = $view->searchFile('index.html','script');
		$this->assertEquals(
			'/opt/www.hazime.org/Nora/doc/sample/view/script/index.html',
			$file
		);
	}

	public function testOutputViewFile( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$view->assign('title','Hajime <web> & site');
		ob_start();
		$view->display('index.html');
		$data = trim(ob_get_contents());
		ob_end_clean();
		$this->assertEquals('<h2>Hajime &lt;web&gt; &amp; site</h2>', $data);
	}

	public function testLayout( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$view->layout( )->set('layout.html');
		$view->assign('title','Hajime <web> & site');
		$data = $view->fetch('sample02.html');
		$this->assertEquals(
			"<!DOCTYPE html>\n<html>\n<head>\n<meta charset=\"utf-8\">\n<title>サンプル&midledot;トップ&midledot;サイト名</title></head>\n<body>\n<h2>サンプル</h2>\n</body>\n</html>\n",
			$data
		);
	}

	public function testHeadStyle( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$view->HeadStyle->appendFile('/assets/css/default.css');
		$view->HeadStyle('body { background : red; }');

		$this->assertEquals(
			"<link rel=\"stylesheet\" media=\"screen\" type=\"text/css\" href=\"/assets/css/default.css\">\n<style media=\"screen\" type=\"text/css\">\nbody { background : red; }\n</style>",
			(string) $view->HeadStyle() 
		);
	}

	public function testLayout2( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$view->layout( )->set('layout02.html');
		$view->assign('title','Hajime <web> & site');
		$data = $view->fetch('sample03.html');
		echo $data;
	}

}










