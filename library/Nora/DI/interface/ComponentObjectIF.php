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
interface ComponentObjectIF
{
	public function init( );
	public function factory();
	public function configure( $array );
	public function config( $name, $value );

	public function setContainer( $container );
	public function getContainer(  );
	public function hasContainer( );
	public function findComponent( $name, $doCreate = true);
	public function requireComponent( $name );
}
