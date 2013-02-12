<?php
namespace Nora\MPDF;

use Nora\DI;
class Component extends DI\Component
{
	use DI\Componentable;


	public function factory( )
	{
		// MPDFのライブラリを読み込む
		require_once 'MPDF56/mpdf.php';

		return $this;
	}

	public function createPDF( $html_string, $watermark_text = null, $output_file = null)
	{
		$mpdf=new mPDF('sjis', 'A4');  

		// ウォーターマークを入れる  
		if(!empty($watermark_text))
		{
			$mpdf->SetWatermarkText( $watermark_text );
			$mpdf->watermark_font = 'DejaVuSansCondensed';  
			$mpdf->showWatermarkText = true;  
		}

		$mpdf->WriteHTML($html_string);

		if( !empty($output_file) )
		{
			return $mpdf->Output( $output_file, 'F');
		}
		else
		{
			$mpdf->Output();
		}
	}
}
