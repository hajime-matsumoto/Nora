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

class FormTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		Nora::init();
		Nora::getInstance()
			->bootstrap
			->addComponent('form', 'Nora\Form\Component');
		$this->form = Nora::getInstance()->bootstrap->form;
	}

	public function testFormInstance( )
	{
		$this->assertInstanceOf( '\Nora\Form\Component', $this->form );
	}
	public function testFormBuild( )
	{
		$form = $this->form->form('test');

		// グループを定義
		// グループには種類がある？ <fieldset><legend> とか Control-groupとか
		$form->addGroup('name','お名前');
		$form->name->addGroup('controls','お名前');
		$form->addGroup('email','ご連絡先(メールアドレス)');
		$form->email->addGroup('controls', 'メールアドレス');
		$form->addActions('actions');

		// 要素を定義
		$form->name->controls
			->addText('surname','姓',array('class'=>'input-small required','x-autocompletetype'=>'surname','maxlength'=>50,'autofocus'))
			->addText('given-name','名',array('placeholder'=>'名','class'=>'input-small required','x-autocompletetype'=>'given-name'));
		$form->email->controls
			->addEmail('email','メールアドレス',array('placeholder'=>'hoge@hoge.com','class'=>'input-block required','x-autocompletetype'=>'email'))
			->addButton('sendcode','確認コード送信',array('class'=>'btn'))
			->addText('code','確認コード',array('placeholder'=>'111111','class'=>'input-small required'));
		$form->actions->addSubmit('confirm','確認ページへ',array('class'=>'btn btn-primary'));

		// ラベルのクラスを指定
		$form->name->controls->getLabel()->setAttributes(array('class'=>'control-label required-label','for'=>'surname'));
		$form->email->controls->getLabel()->setAttributes(array('class'=>'control-label required-label','for'=>'email'));

		echo $form->render();
		/* 期待
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
		 */
	}
}

