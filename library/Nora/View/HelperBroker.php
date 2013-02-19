<?php
namespace Nora\View;

use Nora\DI;
use Nora\Helper;

/**
 * ヘルパーブローカー
 */
class HelperBroker implements DI\ContainerObjectIF,Helper\HelperBrokerObjectIF
{
	use Helper\HelperBrokerObject;

	public function init( )
	{
		// ヘルパを登録
		$this->addHelper('Doctype','Nora\View\Helper\Doctype');
		$this->addHelper('HeadTitle','Nora\View\Helper\HeadTitle');
		$this->addHelper('Placeholder','Nora\View\Helper\Placeholder');
		$this->addHelper('HeadLink','Nora\View\Helper\HeadLink');
		$this->addHelper('HeadMeta','Nora\View\Helper\HeadMeta');
		$this->addHelper('HeadStyle','Nora\View\Helper\HeadStyle');
		$this->addHelper('HeadScript','Nora\View\Helper\HeadScript');

		// HeadScriptをFootScriptとしても使う
		$this->addHelper('FootScript','Nora\View\Helper\HeadScript');
		$this->addHelper('Layout','Nora\View\Helper\Layout');

		// 小技
		$this->addHelper('Gravatar','Nora\View\Helper\Gravatar');
		$this->addHelper('GithubForkMe','Nora\View\Helper\GithubForkMe');
	}
}
