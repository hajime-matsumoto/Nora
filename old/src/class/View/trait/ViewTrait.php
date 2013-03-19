<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   View
 * @package    View
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\View;

use Nora\Base\DI;
use Nora\General\Helper;

/**
 * ビューの機能
 */
trait ViewTrait
{
    use DI\ComponentTrait;
    use Helper\BrokerOwnerTrait;

    /**
     * Viewディレクトリへのパス
     */
    protected $viewPath      = '';
    protected $scriptDir     = 'script';
    protected $partialDir    = 'partial';
    protected $templator     = 'Nora\Template\Templator';
    protected $responseClass = 'Nora\View\Response';

    public function initialize( )
    {
        // ヘルパー処理
        $broker = $this->getHelperBroker( );
        $broker->addHelperDirectory(dirname(__FILE__).'/../Helper','Nora\View\Helper');
    }


    public function setTemplator( $templator )
    {
        $this->templator = $templator;
    }

    public function getTemplator( )
    {
        if( is_string( $this->templator ) )
        {
            $this->setTemplator(nora_class_new_instance($this->templator));
        }
        return $this->templator;
    }

    public function createResponse( )
    {
        $response = nora_class_new_instance($this->responseClass);
        $response->setView( $this );
        return $response;
    }

    public function renderResponse( ResponseIF $response )
    {
        $tpl = $this->viewPath.'/'.$this->scriptDir.'/'.trim($response->getTemplateFile(),'/');
        $tpl.= '.tpl';

        // responseにviewを加える
        $response['view'] = $this;

        return $this->getTemplator( )->renderTemplate( $tpl, $response );
    }
}
