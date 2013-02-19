<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: HeadTitle
 */
class HeadTitle extends Placeholder
{
	public function  __construct( )
	{
		$this->setSeparator(' | ')->setPrefix('<title>')->setPostfix('</title>');
	}

	/** ダイレクトメソッド */
	public function HeadTitle( $value = false, $placement = 'PREPEND' )
	{
		if( $value !== false )
		{
			$this->add( $value, $placement );
		}
		return $this;
	}
}
