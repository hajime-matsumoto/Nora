<?php
namespace Nora\MT;

use Nora\DI;
class Component extends DI\Component
{
	use DI\Componentable;

	private $_mt_dir = '/usr/src/MT-5.2.3/';

	public function factory( )
	{
		// MTのPHPライブラリを読み込み
		require_once( $this->_mt_dir.'/php/mt.php' );
		require_once( $this->_mt_dir.'/php/lib/MTUtil.php' );


		$this->mt = \MT::get_instance(null, $this->_mt_dir.'/mt/mt-config.cgi');
		return $this;
	}

	public function configMTDir( $value )
	{
		$this->_mt_dir = $value;
	}

	/**
	 * @param array SearchParam
	 *
	 * example
	 * 
	 * // 最新10件取得
	 * $args = array(
	 * 'blog_id' => $blog_id,
	 * 'limit' => 10
	 * );
	 * 
	 * 注意: とれない。
	 */
	public function fetchEntries( $args )
	{
		// MTクラス
		$this->mt = \MT::get_instance($args['blog_id'], $this->_mt_dir.'/mt/mt-config.cgi');
		return $this->mt->db()->fetch_entries( $args );
	}
	public function fetchEntry( $id )
	{
		return $this->mt->db()->fetch_entry($id);
	}
}
