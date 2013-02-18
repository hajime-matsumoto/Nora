<?php
/**
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

namespace Nora\DI;

/**
 * コンポーネントインターフェイス
 */
interface ContainerObjectIF
{
	public function addComponent( $name, $resource, $options = array() );
	public function getComponent( $name );
	public function setComponentOptions( $name, $options );
	public function component( $name );
}
