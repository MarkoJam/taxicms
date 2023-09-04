	<script type="text/javascript">
	{literal}
		$('#ajax_default').ready(function(){
			$('#main_category_id').val($('#categoryid').val());
			rootweb=$('#rootweb').val();
			var link=rootweb+'/plugins/plg_{/literal}{$data.plugin}{literal}/{/literal}{$data.plugin}{literal}Ajax.php';
			var param=$('form').serialize();
			console.log(link+'?'+param);
			$.ajax({
				type : 'POST',
				url : link,
				data : param,
				success: function(data) {
					$('#ajax_default').html(data);
					$('.loader').css("display","none");
					$('.itemheight').matchHeight({
										 byRow: true,
								property: 'height',
								target: null,
								remove: false
								});
				}
			})
		})
	{/literal}
	</script>
	<div class="loader"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>
	<form id="" action="" method="post">
		{*ovde ubaciti filtere kao skrivena input polja*}
		<input id='statusarchive' type='hidden' name='statusarchive' value='{$ss}'/>
		<input id='lang' type='hidden' name='lang' value='{$language}'/>
		<input id='offset' type='hidden' name='offset' value='0'/>
		<input id='main_category_id' type='hidden' name='main_category_id' value=''/>
		<input id='language' type='hidden' name='language' value='{$language}'/>
		<input id='pathurl' type='hidden' name='pathurl' value='{$pathurl}'/>
		{if $filterid}<input id='filterid' type='hidden' name='filterid' value='{$filterid}'/>{/if}
	</form>
