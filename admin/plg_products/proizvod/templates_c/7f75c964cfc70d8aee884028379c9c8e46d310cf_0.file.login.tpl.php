<?php
/* Smarty version 3.1.32, created on 2019-08-01 17:14:21
  from 'c:\wamp\www\reimstore\admin\templates\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5d4301cdbb5262_41318718',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7f75c964cfc70d8aee884028379c9c8e46d310cf' => 
    array (
      0 => 'c:\\wamp\\www\\reimstore\\admin\\templates\\login.tpl',
      1 => 1561573166,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d4301cdbb5262_41318718 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\reimstore\\common\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>

<head>
    <title>Administracija - CMS Studio</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
	<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

	<?php echo '<script'; ?>
 type="text/javascript">
	

    var onloadCallback = function() {
     grecaptcha.render('recaptcha', {
		 'sitekey' : '<?php echo $_smarty_tpl->tpl_vars['dkey']->value;?>
'
		 });		 
      };
						
	
	<?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
>
        if (self != top) window.parent.location = "/admin/index.php";

    <?php echo '</script'; ?>
>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">CMS studio</h1>

            </div>

            <form class="m-t" action="index.php" method="post">
                <div class="form-group">
                    <input name="user_name" type="text" placeholder="Username" class="form-control" id="user_name" />
                </div>
                <div class="form-group">
                    <input name="user_password" type="password" placeholder="Password" class="form-control" id="user_password" />
                </div>
                <div class="form-group">
                    <select name="subsiteid" id="subsiteid" class="form-control">
				    <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['subsite_val']->value,'selected'=>$_smarty_tpl->tpl_vars['subsite_sel']->value,'output'=>$_smarty_tpl->tpl_vars['subsite_out']->value),$_smarty_tpl);?>

			         </select>
                </div>

				<button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                <input type="hidden" name="action" id="action" value="login"> <?php if ($_smarty_tpl->tpl_vars['error_login']->value == "true") {?>
                <dt class="error">Login error, please try again.</dt> <?php }?>

                <div class="g-recaptcha" id="recaptcha"></div>
        </div>

        </form>

    </div>
<?php if ($_smarty_tpl->tpl_vars['dkey']->value) {
echo '<script'; ?>
 src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer><?php echo '</script'; ?>
><?php }?>
    <?php echo '<script'; ?>
 src="js/jquery-3.1.1.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/bootstrap.min.js"><?php echo '</script'; ?>
>
    <!-- iCheck -->
    <?php echo '<script'; ?>
 src="js/plugins/iCheck/icheck.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
>
		
            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            });
			$('#subsiteid').change(function() {
				var x = $('#subsiteid option:selected').text();
				if (x != 'Српски') $('#lat').hide();
				else $('#lat').show();
			});
		
        <?php echo '</script'; ?>
>
</body>
</html><?php }
}
