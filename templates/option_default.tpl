<script type="text/javascript">
	{literal}
		$(document).ready(function(){
	/*		function formsubmit() {
				rootweb=$('#rootweb').val();
				var link=rootweb+'/plugins/plg_option/optionAjax.php';
				var param=$('form').serialize();
				$.ajax({
					type : 'POST',
					url : link,
					data : param,
					success: function(data) {
						$('#ajax_default').html(data);
						$('.loader').css("display","none");
					}
				})
			}
			*/
			$('.pager').click(function() {
				var offset = $(this).attr('data-offset');
				$('#offset').val(offset);
				rootweb=$('#rootweb').val();
				var link=rootweb+'/plugins/plg_option/optionAjax.php';
				var param=$('form').serialize();
				console.log (link+'?'+param)
				//alert (link+'?'+param);
				$.ajax({
					type : 'POST',
					url : link,
					data : param,
					success: function(data) {
						$('#ajax_default').html(data);
					}
				})
			})
		})
	{/literal}
</script>
<section class="news-area page-top">
	<div class="container">
		<div class="row">
		{section name=pom loop=$data.option_all}
		<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 itemheight mb-6">
			<a href="{$data.option_all[pom].link_print_dt}">
				<div class="news-group-box">
					<div class="slika" style="background-image:url({$ROOT_WEB}{$data.option_all[pom].slika})"></div>
					<div class="news-content">
						<h5>{$data.option_all[pom].header}</h5>
						{$data.option_all[pom].shorthtml}
						<div class="news-link"><i class="fa-solid fa-chevron-right"></i></div>
					</div>
				</div>	
			</a>
		</div>
		{/section}
	</div>
	<div class="row">
		<div class="col-12">
	 		<nav class="pagination-area ms-md-auto mt-3 mt-md-0">
	     	{$data.pagination}
	 		</nav>
		</div>
	</div>
	<form id="" action="" method="post">
		<input id='offset' name='offset' type='hidden' value=''/>
		<input id='reset' name='reset' type='hidden' value=''/>
		<input id='filter' name='filter' type='hidden' value=''/>
		<input id='language' type='hidden' name='language' value='{$language}'/>
		<input id='main_category_id' name='main_category_id' type='hidden' value='{$smarty.request.main_category_id}'/>
	</form>
	</div>
</div>
</section>
