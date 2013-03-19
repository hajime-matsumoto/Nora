<?=$view->doctype('html5');?>
<!-- vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: -->
<html>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<?=$view->headMeta();?>
<?=$view->headTitle();?>
<?=$view->headStyle();?>
<?=$view->headScript();?>
</head>
<?=$view->placeholder('body')->setPrefix('<body')->setPostfix('>'.PHP_EOL)->setFormat('%s="%s"')?>
<?=$view->githubForkme('hajime-matsumoto/nora'); ?>
<img src="<?=$view->socialGravatar('mail@hazime.org');?>" />
テーマのCSS
<?=$view->placeholder('table');?>

<?=$view->bodyScript()?>
<?=$view->googleAnalytics();?>
</body>
</html>
