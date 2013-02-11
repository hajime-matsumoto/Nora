<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: Doctype
 */
class HeadDoctype
{
	use HelperTool;

	private $_doctype = "";

	/** ダイレクトメソッド */
	public function HeadDoctype( $value )
	{
		switch( strtolower($value) )
		{
		case 'html5':
			$this->_doctype = '<!DOCTYPE html>'.PHP_EOL;
			break;
		default:
			$this->_doctype = $value;
			break;
		}
		return $this;
	}

	public function toString( )
	{
		return $this->_doctype;
	}

}
