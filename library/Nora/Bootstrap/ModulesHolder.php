<?php
/*
 * のらライブラリ
 *---------------------- 
 * ブートスラップー
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Bootstrap;
use Nora\DI;


/**
 * モジュール：ブートストラップホルダー
 *
 * - protected _initから始まるメソッドはコンポーネントファクトリ扱い
 */
class ModulesHolder implements DI\ComponentObjectIF,DI\ContainerObjectIF
{
	use DI\ComponentObject,DI\ContainerObject;

	public function setModulesDir( $dirname, $prefix = 'NoraModule\\' )
	{
		$dir = dir($dirname);
		while( $path = $dir->read() )
		{
			if( 0 === strpos($path,".",0) )
			{
				continue;
			}

			$this->addModule( $path, $dirname.'/'.$path, $prefix.ucfirst($path).'\\' );
		}
	}

	public function addModule( $name, $dir, $prefix )
	{
		$library_path = $dir.'/library';
		$library_path_main = $dir.'/library/'.ucfirst($name).'/';

		// 事前準備
		// =====================================

		// メインライブラリをオートローダーに追加する
		$this->findComponent('libraryloader')->addSearchPath( $library_path );
		// ライブラリをオートローダーに追加する
		$this->findComponent('libraryloader')->addSearchPath( $library_path_main, $prefix );

		// ブートストラップの設定
		// =====================================
		$this->addComponent( $name, $prefix.'Bootstrap',array('moduleDirname'=>$dir) );
	}

	public function init( )
	{

	}

	public function factory( )
	{
		return $this;
	}
}
