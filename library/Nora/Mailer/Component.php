<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Mailer;
use Nora\DI;

/**
 * データベース接続コンポーネント
 */
class Component extends Mailer implements DI\ComponentObjectIF,DI\ContainerObjectIF
{
	use DI\ComponentObject;
	use DI\ContainerObject;

	public function init( )
	{
		$this->addComponent('smtp','Nora\Mailer\SMTP');
	}

	public function factory( )
	{
		$mailer = new Mailer( );
		$mailer->setSMTP( $this->component('smtp') );
		return $mailer;
	}

}
