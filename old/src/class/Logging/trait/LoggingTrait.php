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
 * ロギング可能機能
 */
trait LoggingTrait
    {
        private $_logger = false;

        public function setLogger( $logger )
        {
            $this->_logger = $logger;
        }

        public function getLogger( )
        {
            if( $this->_logger ) return $this->_logger;


            if( $this instanceof DI\ContainerOwnerIF )
            {
                return $this->pullComponent('logging');
            }

            return $this->_logger;
        }

        public function debug( $msg )
        {
            if( !$this->getLogger() ) return;
            $this->getLogger()->debug(func_get_args());
        }

        public function notice( $msg )
        {
            if( !$this->getLogger() ) return;
            $this->getLogger()->notice(func_get_args());
        }
        public function warn( $msg )
        {
            if( !$this->getLogger() ) return;
            $this->getLogger()->warn(func_get_args());
        }
        public function error( $msg )
        {
            if( !$this->getLogger() ) return;
            $this->getLogger()->warn(func_get_args());
        }
    }
