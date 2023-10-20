<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<style type="text/css">
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
.next {
	float: right;
}
.footer {
	background-color: gray;
}
</style>
<section class="cts">
	<div class="container">
		<h2>{$header}</h2>
		<small>{$shorthtml}</small>
		<div class="row">
			<div class="col-lg-2">
				{section name=pom loop=$data.sections_all}
					<ul>
						<li class="left_all" id="{$data.sections_all[pom].sectionsid}">{$data.sections_all[pom].header}</li>
					</ul>
				{/section}
			</div>
			<div class="col-lg-10">
				{section name=pom loop=$data.sections_all}
					<div class="all" data-id="{$data.sections_all[pom].sectionsid}">
						<div class="row">
							<div class="col-lg-6">				
								<button class="previous"><i class="fa fa-arrow-left" aria-hidden="true"></i> PREVIOUS</button>
							</div>	
							<div class="col-lg-6">
								<button class="next">NEXT <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
							</div>	
						</div>	
						<br>	
						<h4>{$data.sections_all[pom].header}</h4>	
						<div class="row">
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
	$(".left_all").first().css("color","red");
	$(".all").first().find(".previous").hide();
	$(".all").last().find(".next").hide();
		
	$(".next").click(function(){
		$(".all").hide();
		$(".left_all").css("color","");
		$(this).parent().parent().parent().next().show();
		var id=$(this).parent().parent().parent().next().attr("data-id");
		$('#'+id).css("color","red");
	})	
	$(".previous").click(function(){
		$(".all").hide();
		$(".left_all").css("color","");
		$(this).parent().parent().parent().prev().show();
		var id=$(this).parent().parent().parent().prev().attr("data-id");
		$('#'+id).css("color","red");
	})
	 
	$("li").click(function(){
		$(".all").hide();
		$(".left_all").css("color","");
		$(this).css("color","red");
		var sectionid=$(this).attr("id");
		$(".all").each(function(){
			if (sectionid==$(this).attr("data-id")) $(this).show(); 
		})
	}) 
</script>
