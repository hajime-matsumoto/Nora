<?php
/*
 * のらライブラリ
 *---------------------- 
 * ブートスラップリソース用のインターフェイス
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Bootstrap;

/**
 * リソース用インターフェイス
 */
interface ResourceIF
{
	public function configure( $configs );
	public function configBootstrapper( $bootstrapper );
	public function getBootstrapper( );
}
