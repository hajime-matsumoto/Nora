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
namespace Nora\Templator;

use Nora\General;
use Nora\General\Helper;

/**
 * テンプレータ用機能
 */
trait TemplatorTrait
{
    use General\SetupableTrait;
    use Helper\BrokerOwnerTrait;
    use Helper\BrokerOwnerShortHandTrait;

    protected $templateDir;
    protected $template;
    protected $vars = array();

    public function __construct( $setup_options = array() )
    {
        $this->setup( $setup_options );
        $this->getHelperBroker()->putServiceDir( 'helper', dirname(__FILE__).'/../Helper', 'Nora\Templator\Helper', $sufix = null );
    }

    public function assign( $name, $value )
    {
        $this->vars[$name] = $value;
    }

    public function render( $template = null, $vars = array() )
    {
        $file = $this->templateDir.'/'.$this->template;
        if( !file_exists($file) ) throw new TemplateFileNotFoundException( $file );

        $use_vars = array_merge( $this->vars, $vars );
        foreach( $use_vars as $k=>$v ){
            $$k = $v;
        }

        ob_start();
        include $file;
        return ob_get_clean();
    }
}

class TemplateFileNotFoundException extends \Exception{}
