<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: HeadTitle
 */
class HeadTitle extends Placeholder
{
	private $_title_parts = array();
	private $_separator = ' | ';

	/** ダイレクトメソッド */
	public function __invoke( $value = false, $placement = 'APPEND')
	{
		return $this->HeadTitle( $value, $placement);
	}

	public function HeadTitle( $value = false, $placement = 'APPEND' )
	{
		if( $value !== false )
		{
			$this->set( $value, $placement );
		}
		return $this;
	}

	public function getPrefix( )
	{
		return '<title>';
	}

	public function getPostfix( )
	{
		return '</title>'.PHP_EOL;
	}

}
