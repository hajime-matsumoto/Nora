<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   View
 * @package    Helper
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\View\Helper\Google;

use Nora\View\Helper;

/**
 * ヘルパー: Analytics
 */
class Analytics extends Helper\Placeholder
{
    protected function _analytics( $account = null )
    {
        if( $account == null ) return;
        $this['account'] = $account;
    }

    public function toString( )
    {
        $text = '<!-- Google Analytics //-->'.PHP_EOL;
        $text.= '<script type="text/javascript">'.PHP_EOL;
        $text.= 'var _gaq = _gaq || [];'.PHP_EOL;
        $text.= '_gaq.push([\'_setAccount\', \''.$this['account'].'\']);'.PHP_EOL;
        $text.= '_gaq.push([\'_trackPageview\']);'.PHP_EOL;
        $text.= '(function() {'.PHP_EOL;
        $text.= 'var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;'.PHP_EOL;
        $text.= 'ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';'.PHP_EOL;
        $text.= 'var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);'.PHP_EOL;
        $text.= '})();'.PHP_EOL;
        $text.= '</script>'.PHP_EOL;
        $text.= '<!-- /Google Analytics //-->'.PHP_EOL;
        return $text;
    }
}
