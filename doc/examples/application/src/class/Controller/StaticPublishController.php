<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Application
 * @package    Application
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace NoraApplication\Controller;

use Nora\Application;

/**
 * コントローラー
 */
class StaticPublishController implements Application\ControllerIF
{
    use Application\ControllerTrait;

    public function actionIndex( $req, $res )
    {
        if( !isset($req['request_uri']) ) return;
        $request_uri = trim($req['request_uri']);

        if( $request_uri == '' || $request_uri == '/' ) $request_uri = 'index.html';

        // 単純なスタティックファイルを探す
        $file = APP_HOME.'/static/'.$request_uri;
        if(file_exists($file)) return $this->doStaticFile( $file, $request_uri );

        $file = APP_HOME.'/static-recipe/'.$request_uri;
        if(file_exists($file)) return $this->doRecipeFile( $file, $request_uri );
        
    }

    public function doRecipeFile( $file, $request_uri )
    {
        $config = new \Nora\Config\ConfigINI();
        $config->load($file);

        switch( $config['type'] )
        {
        case 'file':
            if( !isset($config['file']) || !file_exists($config['file'] ) ) die('Recipe Failed: Cose File Not Found '. $config['file']);
            return $this->doStaticFile( $config['file'], $request_uri );
            break;
        case 'dispatch':
            $res = $this->bootstrap('frontController')->dispatch( $config['params'] );
            break;
        }
    }

    public function doStaticFile( $file, $request_uri )
    {
        // ドキュメントルートに書き出す
        $target = $this->getRequest()->getDocumentRoot().'/'.$request_uri;

        if( $this->bootstrap('config')->getConfig('static.useCache') )
        {
            nora_copy( $file, $target );
        }

        echo file_get_contents($file);
    }
}
