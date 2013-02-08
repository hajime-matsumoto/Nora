<?php
/**
 * のらライブラリ
 */
namespace Nora\DI;

/**
 * DIファクトリ
 */
interface FactoryIF
{
	/** 設定する */
	public function configure( $options );

	/** リソースを生成する */
	public function factory( );

}
