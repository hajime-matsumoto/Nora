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

	public function testViewHelper( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$this->assertInstanceOf('\Nora\View\Helper\HeadDoctype', $view->headDoctype);
		$this->assertEquals('<!DOCTYPE html>'.PHP_EOL, (string) $view->headDoctype('html5'));


		// Gravatar
		$this->assertEquals(
			'http://www.gravatar.com/avatar/414fc9b1b00ad29fda1d22690693c42d?s=200&d=mm',
			(string)$view->gravatar('mail@hazime.org')
		);

		// HeadLinkセットアップ
		$view->headLink()
			->appendStylesheet('/assets/css/default.css')
			->prependStylesheet('/assets/css/base.css');
		$this->assertEquals(
			"<link rel=\"StyleSheet\" href=\"/assets/css/base.css\" media=\"screen\" type=\"text/css\">\n<link rel=\"StyleSheet\" href=\"/assets/css/default.css\" media=\"screen\" type=\"text/css\">\n",
			(string) $view->headLink() 
		);

		// HeadMeta
		$view->HeadMeta( )
			->appendName('keyword','hajime,matsumoto,hp')
			->appendName('description','これは、のらホームページです')
			->appendHttpEquiv('content-type','text/html; charset=utf-8','http-equiv')
			->setCharset('utf-8')
			->setProperty('og:title','Facebook用のタイトル');
		$this->assertEquals(
			"<meta name=\"keyword\" content=\"hajime,matsumoto,hp\">\n<meta name=\"description\" content=\"これは、のらホームページです\">\n<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">\n<meta charset=\"utf-8\">\n<meta property=\"og:title\" content=\"Facebook用のタイトル\">\n",
			(string) $view->headMeta
		);
	}

	public function testHeadScript( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$view->HeadScript('/assets/js/jQuery.js');
		$view->HeadScript('window.onload = function(){ alert("hi"); };','code');

		$this->assertEquals(
			"<script type=\"text/javascript\" charset=\"utf-8\" language=\"javascript\" src=\"/assets/js/jQuery.js\"></script>\n<script type=\"text/javascript\" charset=\"utf-8\" language=\"javascript\">\nwindow.onload = function(){ alert(\"hi\"); };\n</script>",
			(string) $view->HeadScript() 
		);
		$view->FootScript('/assets/js/jQuery.js');
		$view->FootScript('window.onload = function(){ alert("hi"); };','code');
		$this->assertEquals(
			"<script type=\"text/javascript\" charset=\"utf-8\" language=\"javascript\" src=\"/assets/js/jQuery.js\"></script>\n<script type=\"text/javascript\" charset=\"utf-8\" language=\"javascript\">\nwindow.onload = function(){ alert(\"hi\"); };\n</script>",
			(string) $view->FootScript() 
		);
	}

	public function testTipicalView( )
	{
		// 良くありそうなパターン
		$view = Nora::getInstance()->bootstrap->view;
		$view->headTitle('サイト名')->setSeparator('&midledot;');

		// View Script
		$view_script = <<<EOF
<?=\$view->headDoctype('html5');?>
<?=\$view->headTitle('トップ');?>
EOF;
		ob_start();
		$view->evaluation( $view_script );
		$data = ob_get_contents();
		ob_end_clean();
		$this->assertEquals("<!DOCTYPE html>\n<title>サイト名&midledot;トップ</title>\n", $data );
	}

	public function testPlaceholder( )
	{
		// 良くありそうなパターン
		$view = Nora::getInstance()->bootstrap->view;

		$view->placeholder( 'header' )->set('abcde');
		$view->placeholder( 'header' )->set('abcde');
		$view->placeholder( 'header' )->set('abcde');
		$view->placeholder( 'header' )->set('abcde');
		$view->placeholder( 'header' )->set('abcde');

		$this->assertEquals(
			"<p>abcde\nabcde\nabcde\nabcde\nabcde</p>",
			(string) $view->placeholder('header')->setSeparator("\n")->setPrefix('<p>')->setPostfix('</p>') 
		);
	}

	public function testPlaceholderCapture( )
	{
		$view = Nora::getInstance()->bootstrap->view;

		$view->placeholder( 'footer' )->capStart( );
		echo "footer";
		$view->placeholder( 'footer' )->capEnd( );

		$this->assertEquals(
			'footer',
			(string) $view->placeholder('footer')
		)
		;
		$view->placeholder( 'footer' )->capStart( 'name' );
		echo "(c)";
		$view->placeholder( 'footer' )->capEnd( );

		$this->assertEquals(
			'(c)',
			(string) $view->placeholder('footer')->name
		);
	}

	public function testSearchViewFile( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$view->searchFile('index.html','script');
	}

	public function testOutputViewFile( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$view->assign('title','Hajime <web> & site');
		ob_start();
		$view->display('index.html');
		$this->assertEquals('<h2>Hajime &lt;web&gt; &amp; site</h2>', trim(ob_get_contents()));
		ob_end_clean();
	}

	public function testLayout( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$view->layout( )->set('layout.html');
		$view->assign('title','Hajime <web> & site');
		$data = $view->fetch('sample02.html');
		echo $data;
	}

	public function testHeadStyle( )
	{
		$view = Nora::getInstance()->bootstrap->view;
		$view->HeadStyle->appendFile('/assets/css/default.css');
		$view->HeadStyle('body { background : red; }');

		$this->assertEquals(
			"<link rel=\"stylesheet\" media=\"screen\" type=\"text/css\" href=\"/assets/css/default.css\">\n<style>\nbody { background : red; }\n</style>",
			(string) $view->HeadStyle() 
		);
	}
}










