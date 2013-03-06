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
        $name = strtolower($name);
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
        $name = strtolower($name);
        $this->_container_factory[$name] = $factory;

        if(!empty($setting))
        {
            $this->_container_setting[$name] = $setting;
        }
    }

    /**
     * コンポーネントを取得する
     */
    public function pullComponent( $name )
    {
        $name = strtolower($name);
        if( !$this->hasComponent($name) ){
            if( !$this->getContainer( ) ) return false;
            return $this->getContainer()->pullComponent($name);
        }

        if( !$this->_isRegistered( $name ) ) return $this->_initComponent($name);
        return $this->_container_registry[$name];
    }

    /**
     * コンポーネントファクトリを取得する
     */
    public function pullFactory( $name )
    {
        $name = strtolower($name);
        if( !$this->hasComponent($name) ){
            if( !$this->getContainer( ) ) return false;
            return $this->getContainer()->pullFactory($name);
        }

        return $this->_container_factory[$name];
    }

    /**
     * コンポーネントが存在するか
     */
    public function hasComponent( $name )
    {
        $name = strtolower($name);
        if( isset($this->_container_registry[$name]) ) return true;
        if( isset($this->_container_factory[$name]) ) return true;
        return false;
    }

    /**
     * 設定値を取り出す
     */
    public function getComponentSetting( $name )
    {
        $name = strtolower($name);
        if( !isset($this->_container_setting[$name])) return array();
        return $this->_container_setting[$name];
    }

    /**
     * コンポーネントを設定する
     */
    public function setComponentSetting( $name, $setting )
    {
        $name = strtolower($name);
        // 生成済だったら
        if( $this->_isRegistered( $name ) )
        {
            $this->pullComponent($name)->setup($setting);
            return;
        }

        $this->_container_setting[$name] = $setting;
    }

    /**
     * コンポーネントの登録状況を調べる
     */
    private function _isRegistered( $name )
    {
        $name = strtolower($name);
        return isset($this->_container_registry[$name]) ? true: false;
    }

    /**
     * コンポーネントを初期化する
     */
    private function _initComponent( $name, $factory = false )
    {
        $name = strtolower($name);
        //if( !isset($this->_container_factory[$name]) ) return;
        //if( !is_string($this->_container_factory[$name]) ) return;
        //if( !class_exists($this->_container_factory[$name]) ) return;

        if( $factory === false )
        {
            $factory = $this->_container_factory[$name];

            if( is_string($factory) )
            {
                nora_load_util('class');
                return $this->_initComponent( $name, nora_class_new_instance( $factory ) );
            }

            if( $factory instanceof \Closure ){
                return $this->_initComponent( $name, $factory( $this->getComponentSetting($name) )  );
            }

            if( is_array($factory) )
            {
                return $this->_initComponent( $name, call_user_func($factory, $this->getComponentSetting($name)));
            }
        }

        $component = $factory;

        // ContainerOwnerだったら、
        // 所有コンテナの上位コンテナとして自分を登録する
        if( $component instanceof ContainerOwnerIF )
        {
            $component->setContainer('Nora\Base\DI\Container');
            $component->getContainer( )->setContainer( $this );
        }

        // コンポーネントだったら設定を行ってイニシャライズする
        if( $component instanceof ComponentIF )
        {
            $component->setup( $this->getComponentSetting( $name ) );
            $component->initialize( );
        }

        // ブートストラッパだったらブートストラップ用のイニシャライズを行う
        if( $component instanceof BootstrapperIF )
        {
            $component->bootstrapperInitialize();
        }

        // ファクトリだったらfactoryメソッドを呼ぶ
        if( $component instanceof ComponentFactoryIF )
        {
            return $this->_container_registry[$name] = $component->factory();
        }

        return $this->_container_registry[$name] = $component;
    }

    /**
     * コンポーネントをコールする
     */
    public function invokeComponent( $name, $args = array())
    {
        $name = strtolower($name);
        return call_user_func_array( $this->pullComponent($name), $args );
    }
}
