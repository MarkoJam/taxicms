<!-- sidebar area start -->
{if $data.hasKarakteristikeFilter}
<div class="filter-box">
	<script type="text/javascript">
	{literal}
		jQuery(function($) {
			$("#frmFilter input, #frmFilter select").change(function() {
				var change_field = $(this).attr('id');
				var field_content = $(this).val();
				var sList='';
				$(":checkbox:checked").each(function () {
					sList += $(this).attr('data-eid')+',';
				});
				var gpid = $("#grupaproizvodaid").val();
				var p_ids = $("#p_ids").val();
				var st= $(".search-field").val();

				var parameter = "gpid="+gpid+"&p_ids="+p_ids+"&change_field="+change_field+"&field_content="+field_content+"&check_elements="+sList;
				var url = "{/literal}{$ROOT_WEB}{literal}plugins/plg_products/filterAjax.php"
				console.log (url+'?'+parameter)				;
				$.ajax({
					type: "POST",
					url: url,
					data: parameter,
					success: function(data) {
						if (data != "ERROR") {
							$('#catalog-details').html(data);						
							//$('form').submit();
							//$('#submit').trigger('click');
						}
					},
				});
			});

			$("#clear_filters").click(function() {
				$('#fields_form input').val('');
				$('#fields_form select').val(0);
				var gpid = $("#grupaproizvodaid").val();
				var parameter = "gpid="+gpid+"&cf=1";
				var url = "{/literal}{$ROOT_WEB}{literal}plugins/plg_products/filterAjax.php"
				console.log (url+'?'+parameter);
				$.ajax({
					type: "POST",
					url: url,
					data: parameter,
					success: function(data) {
						if (data != "ERROR") {
							$('#num').html($('#grupaproizvoda_count').val());
							$('#catalog-details').html(data);
							$(":checkbox:checked").each(function () {
								$(this).prop( "checked", false );
							});								
							//$('form').submit();
							//$('#submit').trigger('click');
						}
					},
				});
			});


		});

	{/literal}
	</script>
	{* ako postoje proizvodi u izabranoj grupi, crtamo filtere *}
	{if $data.countProizvodiGrupe neq 0}

	<form id="frmFilter" action="{$data.current_link}" method="post">

		<input type="hidden" id="grupaproizvodaid" name="grupaproizvodaid" value="{$data.grupaProizvoda.grupaproizvodaid}" />
		<input type="hidden" id="grupaproizvoda_count"  value="{$data.countProizvodiGrupe}" />
		<input type="hidden" id="p_ids" name="p_ids" value="{$p_ids}" />

		<div id='fields_form' class="widget-filter-size">

	{*	{if $data.hasProizvodjacFilter}
		<h4 class="filter-size-title">Proizvodjač</h4>
		<h4 class="filter-size-title widget-collapsed-title collapsed" data-bs-toggle="collapse" data-bs-target="#widgetTitleId-9">Proizvodjač</h4>
		<div id="widgetTitleId-9" class="collapse widget-collapse-body">
			<div class="filter-form-check ">
				<select class="filter-select" name="proizvodjacid-select" id="proizvodjacid-select">
					<option value="0"
					{if $smarty.session.fields.proizvodjacidselect eq $data.filterItems[cnt].id}selected{/if}
					>All manufactures</option>
					{section loop=$data.filterItems name=cnt}
						{if $data.filterItems[cnt].filtername eq "proizvodjacid"}
							<option value="{$data.filterItems[cnt].id}"
								{if $smarty.session.fields.proizvodjacidselect eq $data.filterItems[cnt].id}selected{/if}
								>{$data.filterItems[cnt].title}</option>
						{/if}
					{/section}
				</select>
			</div>
		</div>
		{/if}


		<h4 class="filter-size-title">Cena</h4>
    <h4 class="filter-size-title widget-collapsed-title collapsed" data-bs-toggle="collapse" data-bs-target="#widgetTitleId-10">Cena</h4>
    <div id="widgetTitleId-10" class="collapse widget-collapse-body">
		<div class="filter-form-check ">
			<div class="double-input-item">
				<input id="cenaa-from" name="cenaa-from" type="number"  value="{$smarty.session.fields.cenaafrom}" placeholder="From">
			</div>
			<div class="double-input-item">
				<input id="cenaa-to" name="cenna-to" type="number"  value="{$smarty.session.fields.cenaato}" placeholder="To" >
			</div>
		</div>
		</div>


*}

		<div class="sidebar-single">
			{section loop=$data.filterItems name=cnt}
				{if $data.filterItems[cnt].filtername eq "karakteristika-free"}
					{if $data.filterItems[$smarty.section.cnt.index_prev].subtitle neq $data.filterItems[cnt].subtitle}

						{if $data.filterItems[cnt].vrsta eq 16}
							<label class="label-select">{$data.filterItems[cnt].subtitle}</label>
							{assign var=XX1 value=kX|cat:$data.filterItems[cnt].id|cat:search}
							<div class="single-input-item">
								<input id="kX{$data.filterItems[cnt].id}-search" name="kX{$data.filterItems[cnt].id}-search" type="text" value="{$smarty.session.fields.$XX1}" placeholder="Search" value="">
							</div>
						{else}
							<label>{$data.filterItems[cnt].subtitle}</label>
							{assign var=XX1 value=kX|cat:$data.filterItems[cnt].id|cat:from}
							<div class="single-input-item">
								<div class="double-input-item">
									<input id="kX{$data.filterItems[cnt].id}-from" name="kX{$data.filterItems[cnt].id}-from" type="number" value="{$smarty.session.fields.$XX1}"  placeholder="From">
								</div>
							{assign var=XX1 value=kX|cat:$data.filterItems[cnt].id|cat:to}
								<div class="double-input-item">
									<input id="kX{$data.filterItems[cnt].id}-to" name="kX{$data.filterItems[cnt].id}-to" type="number"  value="{$smarty.session.fields.$XX1}" placeholder="To" >
								</div>
							</div>
						{/if}
					{/if}
				{/if}
				{if $data.filterItems[cnt].filtername eq "karakteristika" }
					{if $data.filterItems[$smarty.section.cnt.index_prev].subtitle neq $data.filterItems[cnt].subtitle}
						<h2 class="label-select">{$data.filterItems[cnt].subtitle}</h2>
						<ul>
					{/if}
						<li>
						<input 
							{if in_array($data.filterItems[cnt].elementid, $smarty.session.check_elements)}
								checked 
							{/if}
							type="checkbox" class="filter-select" data-eid="{$data.filterItems[cnt].elementid}" id="kX{$data.filterItems[cnt].id}-select" name="kX{$data.filterItems[cnt].id}-select">
						<label class="label-check">{$data.filterItems[cnt].title}</label>
					</li>
					{if $data.filterItems[$smarty.section.cnt.index_next].subtitle neq $data.filterItems[cnt].subtitle}
				</ul>
					{/if}

				{/if}
			{/section}
		</div>
		{/if}

		{if $smarty.session.fields}<div class="filter_no">Filtriranih proizvoda:<span id='num' >{$smarty.session.count_products}</span></div>{/if}

		<div class="clear-btn">
			<button class="btn btn__bg" id='clear_filters' type='button'>Clear filters</button>
		</div>
		<div class="submit-btn">
			{*<input id='submit' class="btn btn__bg" type='submit' val='Submit'/>*}
		</div>
	</div>

	</form>

</div>
{/if}
