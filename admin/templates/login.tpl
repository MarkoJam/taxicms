<!DOCTYPE html>
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

	<script type="text/javascript">
	{literal}

    var onloadCallback = function() {
     grecaptcha.render('recaptcha', {
		 'sitekey' : '{/literal}{$dkey}{literal}'
		 });		 
      };
						
	{/literal}
	</script>

    <script>
        if (self != top) window.parent.location = "/admin/index.php";

    </script>
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
				    {html_options values=$subsite_val selected=$subsite_sel output=$subsite_out}
			         </select>
                </div>
				<div id="lat" class="form-group">
                   <label><div class="icheckbox_square-green" style="position: relative;"><input name="latinica" value="Y" type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> Latinica </label>
                </div>

				<button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                <input type="hidden" name="action" id="action" value="login"> {if $error_login eq "true"}
                <dt class="error">Login error, please try again.</dt> {/if}

                <div class="g-recaptcha" id="recaptcha"></div>
        </div>

        </form>

    </div>
{if $dkey}<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>{/if}
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
        <script>
		{literal}
            $(document).ready(function () {
				$('#lat').hide();
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
		{/literal}
        </script>
</body>
</html>