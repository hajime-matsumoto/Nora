<?php
namespace Modules;
use Nora\Bootstrap\Resource;
use Nora\Form\Form;

class Login extends Resource
{
	public function factory( )
	{
		// 依存関係のチェック
		return $this;
	}

	public function makeForm( )
	{
		$form = new Form( );
		$form->setRequest( $this->bootstrap('request') );
		$form->addText('email','email');
		$form->addText('password','password');
		$form->addCheckbox('remember_me','remember');
		return $form;
	}

	public function login( $email, $passwd, $remember_me )
	{
		if( $email == 'mail@hazime.org' && $passwd == 'deganjue' )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
