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
namespace Nora\Logging;

use Nora\Base\DI;

/**
 * ロガーのファクトリ
 */
class Factory implements DI\ComponentFactoryIF
{
    use DI\ComponentFactoryTrait {
        setup as comonent_setup;
    }

    protected $type = 'default';
    private $_setup_vars = array();

    /**
     * セットアップされた値を保持
     */
    public function setup( $setup )
    {
        $this->_setup_vars = $setup;
        $this->comonent_setup($setup);
    }

    public function factory( )
    {
        nora_load_util('class');
        $logger = nora_class_new_instance("Nora\\Logging\\".ucfirst($this->type).'Logger');
        $logger->setContainer($this);
        $logger->setup( $this->_setup_vars );
        $logger->initialize();
        return $logger;
    }
}
