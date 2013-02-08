<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

namespace Nora\Core;

require_once 'library/core/trait/singleton.php';

class Nora
{
	use Singleton;

	private $_library_loader;

	public function setLibraryLoader( $loaer )
	{
		$this->_library_loader = $loader;
	}
}

