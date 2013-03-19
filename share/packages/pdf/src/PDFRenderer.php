<?php
namespace NoraPKG\PDF;

use Nora\Bootstrap;
use Nora\General;
use Nora\General\Helper;
use Nora\Templator\Templator;
use mPDF;

include_once 'MPDF56/mpdf.php';

class PDFRenderer extends mPDF implements General\SetupableIF,Helper\HelperIF
{
    use General\SetupableTrait;
    use Helper\HelperTrait;

    protected $outputDir = '';
    protected $templateDir = '';

    public function __construct( $setup_options = array())
    {
        $this->setup( $setup_options );
        parent::__construct( 'utf-8', 'A4' );
        //parent::__construct( 'utf-8', 'A4', 0, '', 5, 5, 5, 0, 0, 0);
        $this->useAdobeCJK = true;
    }

    public function PDFRenderer( $html = null )
    {
        if( $html == null ) return $this;

        $this->WriteHTML( $html );
        return $this;
    }

    /**
     * テンプレータを取得する
     */
    public function getTemplator( $tpl_name )
    {
        $tpl = new Templator(array(
            'templateDir'=>$this->templateDir,
            'template'=>$tpl_name
        ));
        $tpl->getHelperBroker()->putHelper('pdfRenderer', $this);
        return $tpl;
    }

    public function writeFile( $file_name )
    {
        $this->output( $this->outputDir.'/'.$file_name );
    }

    public function useWatermark( $text = 'DRAFT' )
    {
        // ウォーターマークを入れる
        $this->SetWatermarkText( $text );
        $this->watermark_font = 'DejaVuSansCondensed';
        $this->showWatermarkText = true;
    }

}
