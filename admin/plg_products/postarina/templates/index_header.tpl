
	<script type="text/javascript">
	{literal}
		$(document).ready(function(){
			$('.new_pos_show').hide();
			$('.new_pos').click(function() {
				$('.new_pos_show').show();
			});
				$('#potvrdi').click(function() {
				modify();	
			})
			
		});
		
	{/literal}
	</script>

<div class="ibox float-e-margins">
	<div class="ibox-title">
		<div class="ibox-tools">
			<a class="collapse-link">
					<i class="fa fa-chevron-up"></i>
			</a>
			<a class="fullscreen-link">
                <i class="fa fa-expand"></i>
            </a>
			<a class="close-link">
				<i class="fa fa-times"></i>
			</a>
		</div>
	</div>
	<div class="ibox-content">
		<div class="table-responsive">



<form id='inner' action="modify_final.php" method="POST" name="formTable">

	<table class="pos table table-bordered">
		<tr><th>{$PLG_RANGE}</th><th>{$PLG_FROM}</th><th>{$PLG_TO}</th><th>{$PLG_PRICE}</th></tr>


