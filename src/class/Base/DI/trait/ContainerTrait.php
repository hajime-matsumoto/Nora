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
 * コンテナーの機能
 */
trait ContainerTrait
{
    use ContainerOwnerTrait;

    private $_container_factory = array();
    private $_container_registry = array();
    private $_container_setting = array();

    /**
     * コンポーネントを削除
     */
    public function removeComponent( $name )
    {
        if( isset($this->_container_factory[$name]) )
        {
            unset($this->_container_factory[$name]);
        }

        if( isset($this->_container_registry[$name]) )
        {
            unset($this->_container_registry[$name]);
        }

        if( isset($this->_container_setting[$name]) ) 
        {
            unset($this->_container_setting[$name]);
        }
    }

    /**
     * コンポーネントを追加
     */
    public function addComponent( $name, $factory, $setting = array() )
    {
        if( isset($this->_container_registry[$name]) ) return;
        if( isset($this->_container_factory[$name]) ) return;
        if( isset($this->_container_setting[$name]) ) return;

        //if( is_object($factory) ) return $this->_container_registry[$name] = $factory;

        $this->_container_factory[$name] = $factory;
        $this->_container_setting[$name] = $setting;
    }

    /**
     * コンポーネントを取得する
     */
    public function pullComponent( $name )
    {
        if( !$this->hasComponent($name) ) return $this->getContainer()->pullComponent($name);
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
        //if( !is_string($this->_container_factory[$name]) ) return;
        //if( !class_exists($this->_container_factory[$name]) ) return;

        $factory = $this->_container_factory[$name];

        if( is_string($factory) )
        {
            nora_load_util('class');
            $component = nora_class_new_instance( $factory );
        }elseif( $factory instanceof \Closure ){
            $component = $factory();
        }else{
            $component = $factory;
        }

        // ContainerOwnerだったら、
        // 所有コンテナの上位コンテナとして自分を登録する
        if( $component instanceof ContainerOwnerIF )
        {
            $component->getContainer( )->setContainer( $this );
        }

        // コンポーネントだったら設定を行ってイニシャライズする
        if( $component instanceof ComponentIF )
        {
            $component->setup( $this->getComponentSetting( $name ) );
            $component->initialize( );
        }

        // ファクトリだったらfactoryメソッドを呼ぶ
        if( $component instanceof ComponentFactoryIF )
        {
            return $this->_container_registry[$name] = $component->factory();
        }

        return $this->_container_registry[$name] = $component;
    }
}
