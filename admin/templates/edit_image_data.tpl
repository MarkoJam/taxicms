<title>Administracija - CMS Studio</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>	  
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="{$ROOT_WEB}admin/css/bootstrap.min.css" rel="stylesheet">
<link href="{$ROOT_WEB}admin/font-awesome/css/font-awesome.css" rel="stylesheet">
<!-- Toastr style -->
<link href="{$ROOT_WEB}admin/css/plugins/toastr/toastr.min.css" rel="stylesheet">
<!-- Sweet Alert -->
<link href="{$ROOT_WEB}admin/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="{$ROOT_WEB}admin/css/animate.css" rel="stylesheet">
<link href="{$ROOT_WEB}admin/css/style.css" rel="stylesheet">
<link href="{$ROOT_WEB}admin/css/plugins/jsTree/style.min.css" rel="stylesheet" />
<script src="{$ROOT_WEB}admin/js/jquery-3.1.1.min.js"></script>


<script>
{literal}
	$(document).ready(function() {
		$('#promeni').click(function() {
			var link = 'save_image_data.php';
			var param = $('form').serialize() ;
			$.ajax({
				type: "POST",
				url: link,
				data: param,
				success: function(data) {
					alert (data);
				}
			})
		})
	})
{/literal}
</script>

<div id="content">
	<form  id='inner' action="modify_final.php" method="post" enctype="multipart/form-data" >
		<input name="image_url" type="hidden" id="$image_url" value="{$image_url}">	
		<div class="form-group"><label class="col-sm-2 control-label">{$PLG_NAME}</label>
			<div class="col-sm-10"><input type="text" id='title' name="title" value="{$title}" class="form-control" placeholder="{$PLG_NAME}"></div>
		</div>
		<div class="form-group"><label class="col-sm-2 control-label">{$PLG_DESCRIPTION}</label>
			<div class="col-sm-10">
				<textarea id="description" name="description" rows="5" cols="50">{$description}</textarea>	
			</div>
		</div>
		<div class="title-action">
			<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i>&nbsp;{$PLG_SAVE}</div>
		</div>			
	</form>
</div>
