<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 * テストファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, nora project all rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正bsdライセンス
 * @version    $id$
 */

namespace Nora\Package;

use Nora\Service;
use Nora\General;
use Nora\General\Helper;

/**
 * アプリケーション
 */
trait ApplicationTrait
{
    use Service\ManagerTrait;
    use General\SetupableTrait;
    use Helper\BrokerOwnerTrait;

    protected $appDirName;
    protected $cfgFileName;
    protected $env;

    public function __construct( $setup_options = array() )
    {
        $this->setup($setup_options);
        $this->getHelperBroker()->putHelper('pkgManager','Nora\Package\Manager');
    }


    public function __call( $name, $args )
    {
        return $this->helper($name)->invokeArgs($args);
    }
}
