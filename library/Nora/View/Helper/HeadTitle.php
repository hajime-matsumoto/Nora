<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: HeadTitle
 */
class HeadTitle extends Placeholder
{
	private $_title_parts = array();
	protected $_separator = ' | ';

	/** ダイレクトメソッド */
	public function __invoke( $value = false, $placement = 'PREPEND')
	{
		return $this->HeadTitle( $value, $placement);
	}

	public function HeadTitle( $value = false, $placement = 'PREPEND' )
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
