<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Container;

/**
 * コンテナ保持パターン用
 *
 * コンテナをメンバ変数として保持し、
 * getContainer( )で外部にも渡せるようにする
 */
trait WithContainer
{
	private $_my_container;

	/**
	 * コンテナ取得
	 *
	 * @return Nora\Container
	 */
	public function getContainer( )
	{
		return $this->_my_container;
	}
}
