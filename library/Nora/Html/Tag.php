<?php
/*
 * のらライブラリ
 *---------------------- 
 * 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Html;

use Nora\Html;

class Tag
{
	use Html\TagObject;

	public function __construct( $name )
	{
		$this->setTagName( $name );
	}
}
