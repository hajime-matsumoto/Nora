<?php
namespace Nora\Filer;

trait Tools
	{
		private $_search_path;

	public function addSearchPath( $path )
	{
		$this->_search_path[] = realpath($path);
	}

	/** ファイルを検索する */
	public function searchFile( $file_name )
	{
		foreach( $this->_search_path as $path )
		{
			$path = sprintf('%s/%s', $path, $file_name );
			if(file_exists($path))
			{
				return $path;
			}
		}
		return false;
	}
}
