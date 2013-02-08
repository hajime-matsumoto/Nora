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

require_once 'Nora/Core/trait/Singleton.php';

class Nora
{
	use Singleton;

	private $_library_loader;

	public function setLibraryLoader( $loader )
	{
		$this->_library_loader = $loader;
	}
}

