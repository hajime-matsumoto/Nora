<?php
require_once '../header.php';

// フォームを取得
$form = NoraBootstrap('login')->makeForm();

// 送信済だったら
// ログイン認証を行う
// - userアプリケーションに委譲してもいいのかも
// - NoraModule('user')->loginForm();
// - NoraModule('user')->loginAuth();
// - NoraModule('user')->checkPerm();
if( NoraBootstrap('request')->isPost() )
{
	$post_values =  $form->takeValues();
	if(
		NoraBootstrap('login')->login( 
			$post_values['email'], 
			$post_values['password'], 
			$post_values['remember_me'] 
		)
	){
		// ログイン成功
		$form->appendMessage('ログイン成功');
	}else{
		// ログイン失敗
		$form->appendErrorMessage('ログイン失敗');
	}
} 
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>のらサンプル &middot; のらログイン</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="./assets/css/bootstrap.css" rel="stylesheet">
		<style type="text/css">
			body {
				padding-top: 40px;
				padding-bottom: 40px;
				background-color: #f5f5f5;
			}

			.form-signin {
				max-width: 300px;
				padding: 19px 29px 29px;
				margin: 0 auto 20px;
				background-color: #fff;
				border: 1px solid #e5e5e5;
				-webkit-border-radius: 5px;
				-moz-border-radius: 5px;
				border-radius: 5px;
				-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
				-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
				box-shadow: 0 1px 2px rgba(0,0,0,.05);
			}
			.form-signin .form-signin-heading,
			.form-signin .checkbox {
				margin-bottom: 10px;
			}
			.form-signin input[type="text"],
			.form-signin input[type="password"] {
				font-size: 16px;
				height: auto;
				margin-bottom: 15px;
				padding: 7px 9px;
			}

		</style>
		<link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="../assets/js/html5shiv.js"></script>
		<![endif]-->

		<!-- Fav and touch icons -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
		<link rel="shortcut icon" href="./assets/ico/favicon.png">
	</head>

	<body>

		<div class="container">

			<form class="form-signin" method="post">
				<h2 class="form-signin-heading">ログインフォーム</h2>
				<?=$form->makeErrorMessage('<div class="alert alert-error">%s</div>')?>
				<?=$form->makeMessage('<div class="alert alert-success">%s</div>')?>
				<input name="email" type="text" class="input-block-level" placeholder="Email address" value="<?=$form->email->takeValue()?>" >
				<input name="password" type="password" class="input-block-level" placeholder="Password" value="<?=$form->password->takeValue()?>">
				<label class="checkbox">
				<input name="remember_me" type="checkbox" value="remember-me" <?=$form->remember_me->ifValue('remember-me','checked','')?> > ログイン状態を保持する
				</label>
				<button name="submit" class="btn btn-large btn-primary" type="submit">ログイン</button>
			</form>

		</div> <!-- /container -->

		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="./assets/js/jquery.js"></script>
		<script src="./assets/js/bootstrap-transition.js"></script>
		<script src="./assets/js/bootstrap-alert.js"></script>
		<script src="./assets/js/bootstrap-modal.js"></script>
		<script src="./assets/js/bootstrap-dropdown.js"></script>
		<script src="./assets/js/bootstrap-scrollspy.js"></script>
		<script src="./assets/js/bootstrap-tab.js"></script>
		<script src="./assets/js/bootstrap-tooltip.js"></script>
		<script src="./assets/js/bootstrap-popover.js"></script>
		<script src="./assets/js/bootstrap-button.js"></script>
		<script src="./assets/js/bootstrap-collapse.js"></script>
		<script src="./assets/js/bootstrap-carousel.js"></script>
		<script src="./assets/js/bootstrap-typeahead.js"></script>

	</body>
</html>