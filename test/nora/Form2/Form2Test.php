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
use Nora\Html\Form\Form;

class FormTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		Nora::init();
		$this->form = new Form();
	}

	public function testFormCreateText( )
	{
		$text = $this->form->createText('surname');
		$this->assertInstanceOf('Nora\Html\Form\Element\Text', $text);
		$this->assertInstanceOf('Nora\Html\Form\Element\Label', $text->label());
		$this->assertInstanceOf('Nora\Html\Form\Element\Help', $text->help());
		$this->assertInstanceOf('Nora\Html\Form\Renderer\Renderer', $text->renderer());

		// レンダリングしてみる
		$text->help('名前です');
		$text->label('名前');
		echo $text->render( );
	}

	public function testFormCreateGroup( )
	{
		// パーツを作成する
		$surname = $this->form->createText('surname')->setAttr('class','input-small')->setAttr('placeholder','姓');
		$given = $this->form->createText('given')->setAttr('class','input-small')->setAttr('placeholder','名');

		$group = $this->form->createGroup('name')->setAttr('class','control-group');
		$group->help('姓・名です');
		$group->label('氏名')->setFor('surname');
		$group->error();
		$group->addElement( $surname, $given );

		echo $group->render();
	}

	public function testFormCreateGeneral( )
	{
		$this->form->group('name')
			->setAttr('class','control-group')
			->setHelp('氏名を入力してください')
			->setLabel('氏名')
			->addText('surname')
			->addText('given')
			->each(function($e){ $e->renderer( )->setAttr('class','input-small');});

		// 検索パターンA
		$result = $this->form->search(function($e){ $id = $e->getId(); return in_array($id,array('surname')); });
		$this->assertEquals(1, count($result) );
		// 検索パターンB
		$result = $this->form->search(array('surname','given'));
		$this->assertEquals(2, count($result) );

		// 出力テスト
		echo $this->form->render();

	}
	/*
	public function testFormInstance( )
	{
		$this->assertInstanceOf( '\Nora\Html\Form\Component', $this->form );
	}

	public function testGeneralFormBuild()
	{
		$form = $this->form->form('test');

		$form->addFieldset('root', array('legend'=>'お名前') );

		$form->root->addControlGroup('name',false,array('class'=>'control-group'));
		$form->root->name->label('お名前',false,array('class'=>'control-label'));
		$form->root->name->addControls('controls',false,array('class'=>'controls'));
		$form->root->name->controls
			->addText('surname',false,array('placeholder'=>'姓'))
			->addText('given-name',false,array('placeholder'=>'名'));
			<fieldset>
			<legend>お名前</legend>
			<div class="control-group">
			<label class="control-label require-label" for="customer-surname">お名前</label>
			<div class="controls">
			<input type="text" id="customer-surname" name="name01" value="" maxlength="50" class="input-small required" placeholder="姓" x-autocompletetype="surname" autofocus>
			<input type="text" name="name02" value="" maxlength="50" class="input-small required" placeholder="名" x-autocompletetype="given-name">
			</div>
			</div>
			<div class="control-group">
			<label class="control-label require-label" for="customer-surname-kana">お名前(フリガナ)</label>
			<div class="controls">
			<input type="text" id="customer-surname-kana" name="kana01" value="" maxlength="50" class="input-small required" placeholder="セイ">
			<input type="text" name="kana02" value="" maxlength="50" class="input-small required" placeholder="メイ">
			</div>
			</div>
			</fieldset>

		$form->setAttr('method','post');
		$form->setAttr('action','/');
		$form->fieldset('name_field','お名前');
		$form->name_field->group('name',array('class'=>'control-group'))
			->setLabel('お名前',array('class'=>'control-label'))
			->controls(false,array('class'=>'controls'))
			->addText('surname',array('class'=>'input-small'))
			->addText('given_name',array('class'=>'input-small'));
		$form->root->group('zipcode')
			->setLabel('郵便番号')
			->addText('zipcode1')
			->addText('zipcode2');

		echo $form->render();
	}
	public function testGeneralFormBuild()
	{
		$form = $this->form->form('test');
		$form
			->fieldset('name')->setLegend('お名前')
			->controlGroup('name',array('class'=>'control-group'))
			->controls('name',array('class'=>'controls'))
			->setLabel('お名前',array('class'=>'control-label'))
			->addText('surname',array('class'=>'input-small'),array('placeholder'=>'姓'))
			->addText('given_name',array('class'=>'input-small'),array('placeholder'=>'名'));
		echo $form->build();
	}

	public function testFormBuild( )
	{
		// 複雑なパターン
		$form = $this->form->form('test');
		$controls = $form->fieldset('name')->setLegend('お名前')->controlGroup('name',array('class'=>'control-group'))->controls('name',array('class'=>'controls'));
		$controls->label('お名前')->setAttributes(array('class'=>'control-label','for'=>'surname'));
		$controls
			->addText('surname',array(), array('placeholder'=>'姓'))
			->addText('given_name',array(),array('placeholder'=>'名'));
		echo $form->build();
	}

	public function testFormBuild2( )
	{
		// シンプルなパターン
		$form = $this->form->form('test2');
		$form->text('name')->label('名前');
		echo $form->build();
	}
	 */
}

