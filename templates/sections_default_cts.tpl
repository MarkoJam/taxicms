<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<style type="text/css">
	/* Layout: */
	.container-edit{
		padding-bottom: 15px;
	}

	.row .footer {
		background-color: rgb(235 235 235);
		margin: 0;
	}
	/* ------------------------------------------ */

	.cts img:hover {
	-webkit-transform: scale(4,4);
	}
	img, video {
		width: 100%;
	}
	li {
		font-size: 80%;
		color:#338FFF;
		cursor: pointer;
	}

	.next-edit {
		float: right;
	}
	.previous-edit, .next-edit{
		padding: 1px 8px;
		border: 1px solid #d1cece;
		border-radius: 5px;
	}

	.col-lg-2-edit .left_all_edit:hover{
		color:rgb(98, 95, 252) !important;
		font-weight: bold;
	}
	/* .col-lg-2-edit .left_all_edit:visited{
		color:black !important;
	} */
	.col-lg-2-edit{
		border-right: 1px dashed #bfbfbf;
		padding-top: 15px;
		padding-bottom: 15px;
	}
	.col-lg-10-edit{
		padding: 10px;
	}
	.col-lg-10-edit .row-edit{
		min-height: 45vh;
	}
</style>

<section class="cts">
	<div class="container container-edit">
		<h2>{$header}</h2>
		<small>{$shorthtml}</small>
		<div class="row">
			<div class="col-lg-2 col-lg-2-edit">
				{section name=pom loop=$data.sections_all}
					<ul>
						<li class="left_all left_all_edit" id="{$data.sections_all[pom].sectionsid}">{$data.sections_all[pom].header}</li>
					</ul>
				{/section}
			</div>
			<div class="col-lg-10 col-lg-10-edit">
				{section name=pom loop=$data.sections_all}
					<div class="all" data-id="{$data.sections_all[pom].sectionsid}">
						<div class="row">
							<div class="col-lg-6">				
								<button class="previous previous-edit"><i class="fa fa-arrow-left" aria-hidden="true"></i> PREVIOUS</button>
							</div>	
							<div class="col-lg-6">
								<button class="next next-edit">NEXT <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
							</div>	
						</div>	
						<br>	
						<h4>{$data.sections_all[pom].header}</h4>	
						<div class="row row-edit">
							<div class="col-lg-8">
								{$data.sections_all[pom].html}
							</div>				
							<div class="col-lg-4">
								<img src="{$ROOT_WEB}{$data.sections_all[pom].slika}"/>
							</div>
						</div>
						<hr>
						<div class="row footer">
							<div class="col-lg-2">
								{if $data.sections_all[pom].sectionlink}
									<a target="_blank" href="{$data.sections_all[pom].sectionlink}">WIS <i class="fa fa-link" aria-hidden="true"></i></a>				
								{/if}
							</div>
							<div class="col-lg-2">
								{if $data.sections_all[pom].video}
									Tutorial
									<a target="_blank" href="{$data.sections_all[pom].video}">
										<video class="responsive" autoplay muted loop>
											<source class="video" src="{$data.sections_all[pom].video}" type="video/mp4" />				
										</video>
									</a>
								{/if}
							</div>
						</div>							
					</div>
				{/section}
			</div>
		</div>	
	</div>
</section>
<script>
	$(".all").hide();
	$(".all").first().show();
	$(".left_all").first().css({
			'color':'blue',
			'font-weight':'bold',
		});
	$(".all").first().find(".previous").hide();
	$(".all").last().find(".next").hide();
		
	$(".next").click(function(){
		$(".all").hide();
		$(".left_all").css("color","");
		$(this).parent().parent().parent().next().show();
		var id=$(this).parent().parent().parent().next().attr("data-id");
		$('#'+id).css("color","blue");
	})	
	$(".previous").click(function(){
		$(".all").hide();
		$(".left_all").css("color","");
		$(this).parent().parent().parent().prev().show();
		var id=$(this).parent().parent().parent().prev().attr("data-id");
		$('#'+id).css("color","blue");
	})
	 
	$("li").click(function(){
		$(".all").hide();
		$(".left_all").css("color","");
		$(this).css({
			'color':'blue',
			'font-weight':'bold',
		});
		var sectionid=$(this).attr("id");
		$(".all").each(function(){
			if (sectionid==$(this).attr("data-id")) $(this).show(); 
		})
	})
</script>
