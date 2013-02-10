<?php require_once '../header.php'; ?>
<!DOCTYPE html>
<meta charset='utf-8'>
<style>
label { display:block; }
</style>
<h1>電話をかける</h1>


<h2>つながるまでかける</h2>
<form method="post">

<label>掛ける相手</label>
<input type="text" name="channel" value="SIP/99061035@75755600" style="width:300px">

<label>つなぎ先</label>
<input type="text" name="exten" value="201*1">

<fieldset>
<legend>繰り返し設定</legend>
<pre>
# 月曜日:1 火曜日:2 水曜日:3 木曜日:4 金曜日:5 土曜日:6 日曜日:7 or 0
# 「分」「時」「日」「月」「曜日」
0,30 11-21 * * 1-5
</pre>

<label>分</label>
<input type="text" name="minuts" value="0,30"/>
<label>時</label>
<input type="text" name="hour" value="11-21" />
<label>日</label>
<input type="text" name="day" value="*"/>
<label>月</label>
<input type="text" name="month" value="*" />
<label>曜日</label>
<input type="text" name="weekday" value="1-5" />

</fieldset>


<input type="submit" value="設定" />

</form>

コールヒストリー
<table>
<?php foreach(NoraBootstrap('app')->callHistory() as $row): ?>
<tr>
<td><?=$row['calldate']?></td>
<td><?=$row['clid']?></td>
<td><?=$row['src']?></td>
<td><?=$row['dst']?></td>
<td><?=$row['channel']?></td>
<td><?=$row['lastapp']?></td>
<?php //var_dump($row); ?>
</tr>

<?php endforeach; ?>

</table>

