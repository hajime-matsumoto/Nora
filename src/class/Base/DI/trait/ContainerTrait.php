<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Base\DI;

/**
 * コンテナーの機能
 */
trait ContainerTrait
{
    private $_container_factory = array();
    private $_container_registry = array();
    private $_container_setting = array();

    /**
     * コンポーネントを削除
     */
    public function removeComponent( $name )
    {
        if( !isset($this->_container_factory[$name]) ) return;
        unset($this->_container_factory[$name]);

        if( !isset($this->_container_registry[$name]) ) return;
        unset($this->_container_registry[$name]);

        if( !isset($this->_container_setting[$name]) ) return;
        unset($this->_container_setting[$name]);
    }

    /**
     * コンポーネントを追加
     */
    public function addComponent( $name, $factory, $setting = array() )
    {
        if( isset($this->_container_registry[$name]) ) return;
        if( isset($this->_container_factory[$name]) ) return;
        if( isset($this->_container_setting[$name]) ) return;

        if( is_object($factory) ) return $this->_container_registry[$name];

        $this->_container_factory[$name] = $factory;
        $this->_container_setting[$name] = $setting;
    }

    /**
     * コンポーネントを取得する
     */
    public function pullComponent( $name )
    {
        if( !$this->_isRegistered( $name ) ) return $this->_initComponent($name);
        return $this->_container_registry[$name];
    }

    /**
     * コンポーネントが存在するか
     */
    public function hasComponent( $name )
    {
        if( isset($this->_container_registry[$name]) ) return true;
        if( isset($this->_container_factory[$name]) ) return true;
        return false;
    }

    /**
     * 設定値を取り出す
     */
    public function getComponentSetting( $name )
    {
        if( !isset($this->_container_setting[$name])) return array();
        return $this->_container_setting[$name];
    }

    /**
     * コンポーネントの登録状況を調べる
     */
    private function _isRegistered( $name )
    {
        return isset($this->_container_registry[$name]) ? true: false;
    }

    /**
     * コンポーネントを初期化する
     */
    private function _initComponent( $name )
    {
        if( !isset($this->_container_factory[$name]) ) return;
        if( !is_string($this->_container_factory[$name]) ) return;
        //if( !class_exists($this->_container_factory[$name]) ) return;

        nora_load_util('class');
        $factory = nora_class_new_instance( $this->_container_factory[$name] );

        // ContainerOwnerだったら、自分をコンテナとして登録する
        if( $factory instanceof ContainerOwnerIF )
        {
            $factory->setContainer( $this );
        }

        // コンポーネントだったら設定を行ってイニシャライズする
        if( $factory instanceof ComponentIF )
        {
            $factory->setup( $this->getComponentSetting( $name ) );
            $factory->initialize( );
        }

        // ファクトリだったらfactoryメソッドを呼ぶ
        if( $factory instanceof ComponentFactoryIF )
        {
            return $this->_container_registry[$name] = $factory->factory();
        }

        return $this->_container_registry[$name] = $factory;
    }
}
