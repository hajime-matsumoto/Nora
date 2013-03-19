<?php
namespace NoraPKG\PDF\Controller;

use Nora\Controller;
use NoraPKG\PDF\PDFRenderer;

class Home extends Controller\ActionController
{
    public function IndexAction( )
    {
        // PDF生成
        $pdf = new PDFRenderer(array(
            'outputDir'=>NORA_HOME.'/public/pdf',
            'templateDir'=>PKG_PDF_HOME.'/template/pdf'
        ));
        //$pdf->useWatermark('SAMPLE');
        $tpl = $pdf->getTemplator('invoice.tpl');
        $tpl->date()->setFormat('Y年n月d日');
        $tpl->placeholder('自社情報')
            ->fields('会社名','郵便番号','住所','電話','FAX','担当者')
            ->assign('株式会社アバップ','152-0011','東京都目黒区原町2-8-14','03-3761-4235','03-3760-4235','松本創');

        $tpl->placeholder('振込先')
            ->fields('銀行名','支店名','口座種別','口座番号','名義人')
            ->assign('三井住友銀行','洗足支店','普通','6624135','株式会社アバップ');

        // 固有情報
        /*
        $tpl->placeholder('請求先')
            ->fields('会社名')
            ->assign('株式会社ヴィスティー');

        $tpl->placeholder('請求書')
            ->fields('請求番号','件名','請求締日','支払期日','備考','税率','金額単位')
            ->assign('VST-1304-S01','Visty英語学習サイト保守','20130415','20130425','請求書のフォーマットを変更しました。',0.05,'円');

        $tpl->placeholder('items')
            ->fields('項目名','数量','単位','単価')
            ->add('運用保守','1','式',30000);
         */
        $tpl->placeholder('請求先')
            ->fields('会社名')
            ->assign('谷口パートナーズ会計・税務事務所');

        $tpl->placeholder('請求書')
            ->fields('請求番号','件名','請求締日','支払期日','備考','税率','金額単位')
            ->assign('KKK-1303-S01','究極会計WEBサイト作成','20130320','別途ご相談','名目上納品書も兼ねておりますが残タスクが存在しており、
            実質この請求書作成時点で納品は完了しておりません。',0.05,'円');

        $tpl->placeholder('items')
            ->fields('項目名','数量','単位','単価')
            ->add('WEBサイト開発','1','式',150000);


        $tpl->pdfRenderer()->kakuin = file_get_contents(PKG_PDF_HOME.'/etc/kakuin.png');
        $tpl->pdfRenderer()->hanko_creater= file_get_contents(PKG_PDF_HOME.'/etc/hanko.png');
        $tpl->pdfRenderer()->hanko_aprover= file_get_contents(PKG_PDF_HOME.'/etc/hanko.png');
        $tpl->pdfRenderer($tpl->render())->writeFile('kkk-1303-S01.pdf');
    }
}
