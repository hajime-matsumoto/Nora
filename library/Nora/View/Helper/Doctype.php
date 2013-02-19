<?php
namespace Nora\View\Helper;

use Nora\Container\Container;
use Nora\Helper;

/**
 * ヘルパー: Doctype
 */
class Doctype extends Placeholder
{
	public function __construct( )
	{
		$this->setFormat("%s\n");
	}

	/** ダイレクトメソッド */
	public function Doctype( $value = null )
	{
		if( $value !== null  )
		{
			switch( strtolower($value) )
			{
			case 'html5':
				$this['doctype'] = '<!DOCTYPE html>';
				break;
			default:
				$this['doctype'] = $value;
				break;
			}
		}
		return $this;
	}
}
