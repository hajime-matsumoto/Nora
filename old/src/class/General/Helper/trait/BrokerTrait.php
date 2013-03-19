<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\General\Helper;

use Nora\Base\DI;

/**
 * ヘルパーブローカ
 */
trait BrokerTrait
{
    use DI\ContainerTrait;

    private $_boker_owner;

    /**
     * オーナーを設定する
     */
    public function setOwner( $owner )
    {
        $this->_broker_owner = $owner;
    }

    /**
     * オーナーを取得する
     */
    public function getOwner(  )
    {
        return $this->_broker_owner;
    }

    /**
     * ヘルパブローカディレクトリを追加する
     */
    public function addHelperDirectory( $directory, $namespace, $name_prefix = '' )
    {
        if( !is_dir($directory) ) return;

        $dir = dir($directory);
        while( $file = $dir->read( ) )
        {
            if( nora_string_starts_with( $file, '.' ) ) continue;

            if( is_dir( $directory.'/'.$file ) && $file != 'interface' && $file != 'trait' ) {
                $this->addHelperDirectory( $directory.'/'.$file, $namespace.'\\'.$file, $file);
                continue;
            }
            if( !nora_string_ends_with( $file, '.php') ) continue;

            $len   = strlen($file);
            $class = substr($file,0,$len-4);
            $name  = lcfirst($class);

            $this->addHelper( $name_prefix.$name, $namespace.'\\'.$class );
        }

    }

    /**
     * ヘルパを追加する
     */
    public function addHelper( $name, $class )
    {
        $this->addComponent( $name, $class );
    }


    /**
     * ヘルパを取得する
     */
    public function pullHelper( $name )
    {
        return $component = $this->pullComponent( $name );
    }

    /**
     * ヘルパがあるか
     */
    public function hasHelper( $name )
    {
        return $this->hasComponent( $name );
    }


    /**
     * ヘルパをコールする
     */
    public function invokeHelper( $name, $args )
    {
        return $this->invokeComponent( $name, $args );
    }
}
