<!--<?php
// vim: set ft=html:
/**
* 請求書用のテンプレート
*/
$sub_total = 0;
foreach( $this->placeholder('items') as $no=>$item){
$sub_total = $sub_total + $item['単価']*$item['数量'];
}
$tax = ceil($sub_total * $this->placeholder('請求書')->税率);
$total = $sub_total + $tax;
?>-->
<html>
  <head>
    <style>
      body {
        font-family : ipa;
      }
      body,td,th {
        font-size:12px;
      }

      table {
        border-collapse:collapse;
      }
      #comp_name {font-size:15px;}

      #invoice {
      }
      #invoice th {
        color : #FFFFFF;
        background : #466478;
        font-weight : normal;
        border-left: 1px solid #FFFFFF;
        border-bottom: 2px solid #FFFFFF;
        border-collapse:collapse;
        padding : 1mm 0mm;
      }
      #invoice th.last {
        border-right: 1px solid #FFFFFF;
        border-left: 1px solid #FFFFFF;
        border-collapse:collapse;
      }
      #invoice td {
        border-bottom: 1px solid #000000;
        border-collapse:collapse;
        padding : 1mm 1mm;
      }
      #invoice td.last {
        border-right: 1px solid #FFFFFF;
        border-collapse:collapse;
        border-right: none;
      }

      #summary th{
        color : #FFFFFF;
        background : #466478;
        font-weight : normal;
        text-align: left;
        padding-left: 20px;
        padding-right: 20px;
        border: 1px solid #466478;
      }
      #summary td{
        width : 100px;
        text-align: right;
        border: 1px solid #466478;
        padding : 1mm 1mm;
      }

    </style>
  </head>
  <body lang='ja'>

    <table cellspacing=0 cellpadding=0 width="100%">
      <tr>
        <td style="width:25mm;height:25mm;font-size:16px;background:#466478;color:#EEE;text-align:center">
          納品書<br />
          兼<br />
          請求書<br />
        </td>
        <td rowspan="2" style="width:30px;">&nbsp;</td>
        <td rowspan="8" style="width:1px;border-left:2px solid #466478;">
          &nbsp;
        </td>
        <td rowspan="8" style="width:40px;">&nbsp;</td>
        <td colspan="2" style="text-align:right;vertical-align:top">
          請求書No. <?=$this->placeholder('請求書')->請求番号?>
        </td>
      </tr>

      <tr>
        <td>&nbsp;</td>
        <td style="text-align:left;font-size:17px;vertical-align:top;padding-bottom:30px;">
          <span style="text-decoration:underline;"><?=$this->placeholder('請求先')->会社名?></span>　<b>御中</b>
        </td>
        <td rowspan="8" style="width:45mm;text-align:right;padding-top:10px;vertical-align:top">
          <table><tr><td style="text-align:center">
                <div id="comp_name"><?=$this->placeholder('自社情報')->会社名?></div>
                <div id="comp_postal">〒<?=$this->placeholder('自社情報')->郵便番号?></div>
                <div id="comp_address"><?=$this->placeholder('自社情報')->住所?></div>
                <div id="comp_in_charge_of">担当者:松本創</div>
                <div id="comp_tel">Tel:<?=$this->placeholder('自社情報')->電話?></div>
                <div id="comp_fax">Fax:<?=$this->placeholder('自社情報')->FAX?></div>
                <div>
                  <img src="var:kakuin" style="margin-top:5px" width="100px">
                </div>
          </td></tr></table>
        </td>
      </tr>

      <tr>
        <td colspan="2" style="padding-left:30px;"><span style="color:#466478">■</span>御請求価格</td>
        <td>
          <table>
            <tr>
              <td style="border:2px solid #466478;padding:1mm 0mm 1mm 7mm;text-align:left;width:60mm;font-size:17px;"><?=$this->keta($total)?></td>
              <td style="vertical-align:bottom;padding-left:10px;color:gray;font-size:16px;"><?=$this->placeholder('請求書')->金額単位?></td>
            </tr>
          </table>
        </td>
      </tr>

      <tr>
        <td colspan="2"></td>
        <td>
          表示金額には消費税<?=$this->placeholder('請求書')->税率*100?>%が含まれております。
        </td>
      </tr>

      <tr>
        <td colspan="2" style="padding-top:10px;padding-left:30px;"><span style="color:#466478">■</span>件名</td>
        <td style="padding-top:10px;font-size:15px;font-weight:bold">
          <?=$this->placeholder('請求書')->件名?>
        </td>
      </tr>

      <tr>
        <td colspan="3" style="padding-top:10px;padding-left:30px;"><span style="color:#466478">■</span>納品/請求締日</td>
        <td style="padding-top:10px;text-align:left;padding-left:1mm;letter-spacing:2px;font-size:15px;">
          <?=$this->date($this->placeholder('請求書')->請求締日)?>
        </td>
      </tr>

      <tr>
        <td colspan="3" style="padding-top:10px;padding-left:30px;"><span style="color:#466478">■</span>支払期日</td>
        <td style="padding-top:10px;text-align:left;padding-left:1mm;letter-spacing:2px;font-size:15px;">
          <?=$this->date($this->placeholder('請求書')->支払期日)?>
        </td>
      </tr>
      <tr>
        <td colspan="3" style="padding-top:10px;vertical-align:top;padding-left:30px;"><span style="color:#466478">■</span>お振込先</td>
        <td style="padding-top:10px;text-align:left;padding-left:1mm;letter-spacing:2px;font-size:14px;">
          <?=$this->placeholder('振込先')->銀行名?>
          <?=$this->placeholder('振込先')->支店名?><br>
          <?=$this->placeholder('振込先')->口座種別?>
          <?=$this->placeholder('振込先')->口座番号?><br>
          <?=$this->placeholder('振込先')->名義人?><br>
          <small>※お振込手数料は貴社にてご負担お願いします。</small>
        </td>
      </tr>
    </table>


    <div style="text-align:right">金額単位:<?=$this->placeholder('請求書')->金額単位?></div>
    <table id="invoice" autosize="1"  width="100%">
      <thead>
        <tr><th width="4%">No.</th><th width="46%">項目名</th><th width="10%">数量</th><th width="10%">単位</th><th width="10%">単価</th><th class="last" width="10%">金額</th></tr>
      </thead>
      <tbody>
        <!-- 項目のループ始まり -->
        <?php foreach( $this->placeholder('items') as $no=>$item): ?>
        <tr>
          <td align="center"><?=++$no?></td>
          <td><?=$item['項目名']?></td>
          <td align="right"><?=$this->keta($item['数量'])?></td>
          <td align="center"><?=$item['単位']?></td>
          <td align="right"><?=$this->keta($item['単価'])?></td>
          <td class="last" align="right"><?=$this->keta($item['単価']*$item['数量'])?></td>
        </tr>
        <?php endforeach; ?>
        <!-- 項目のループ終わり -->
      </tbody>
    </table>

    <!-- 計算 -->
    <br>
    <table width="100%"><tr><td align="right">
          <table id="summary">
            <tr>
              <th>小計</th><td><?=$this->keta($sub_total)?></td>
            </tr>
            <tr>
              <th>消費税(5%)</th><td><?=$this->keta($tax)?></td>
            </tr>
            <tr>
              <th>合計</th><td><?=$this->keta($total)?></td>
            </tr>
          </table>
    </td></tr></table>

    <table width="100%"><tr><td style="text-align:center;font-size:14px;">
          上記金額を御請求申し上げます。
    </td></tr></table>

    <table width="100%">
      <tr>
        <td><h3 style="font-weight:normal">備考欄</h3></td>
      </tr>
      <tr>
        <td style="width:80%;height:40mm;border:0.1mm solid #000;vertical-align:top;padding:1mm;">
          <?=nl2br($this->placeholder('請求書')->備考)?>
          &nbsp;
        </td>
        <td style="text-align:right;vertical-align:top">
          <table><tr><td style="border:1px solid #CCC;padding:2mm">承<br/>認</td><td width="60px" style="border:1px solid #CCC;padding:2mm"><img src="var:hanko_aprover" width="40px"></td></tr></table>
          <table><tr><td style="border:1px solid #CCC;padding:2mm">作<br/>成</td><td width="60px" style="border:1px solid #CCC;padding:2mm"><img src="var:hanko_creater" width="40px"></td></tr></table>
        </td>
      </tr>
    </table>

    <!-- 備考 -->
    <htmlpagefooter name="footer">
    </htmlpagefooter>

    <sethtmlpagefooter name="footer" value="on" />

  </body>
</html>
