<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @category   Base
 * @package    DI
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Base\DI;

/**
 * コンテナーオーナーの機能
 */
trait ContainerOwnerTrait
{
	private $_di_container = 'Nora\Base\DI\Container';

	/**
	 * コンテナをセットする
	 *
	 * @param string|object クラス名かオブジェクト実体
	 */
	public function setContainer( $container )
	{
		$this->_di_container = $container;
	}

	/**
	 * コンテナを取得する
	 */
	public function getContainer(  )
    {
		nora_load_util('class');

		if( is_string( $this->_di_container ) )
		{
			$this->setContainer( nora_class_new_instance( $this->_di_container ) );
        }

        return $this->_di_container;
    }

    /**
     * コンポーネントを検索する
     */
    public function pullComponent( $name )
    {
        return $this->getContainer( )->pullComponent($name);
    }
}
