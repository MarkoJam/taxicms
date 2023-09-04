<script type="text/javascript" src="CKeditor/ckeditor/ckeditor.js"></script>
		   <!-- iCheck -->
		<script src="{$ROOT_WEB}js/plugins/iCheck/icheck.min.js"></script>

	<script>
    {literal}
        function modify_plugin() {
            // promena href u data
			$('#inner table a').each(function() {
                var href = $(this).attr('href');
                $(this).removeAttr('href');
                $(this).attr('data-link',(href.split('?'))[0]);
				$(this).attr('data-param',(href.split('?'))[1]);
            });

			// pomeranje-sortiranje redova tabele
			$('#inner #normal tbody').attr('id', 'tabledivbody');
			$('#inner #tabledivbody tr').addClass('sectionsid');
			$('#inner #tabledivbody tr').hover(function() {
				$(this).toggleClass('highlight');
			});
			$('#inner #tabledivbody').sortable({
				revert: true,
				items: 'tr:not(.header)',
				axis: 'y',
				cursor: 'move',
				opacity: 0.6,
				update: function() {
					sendOrderToServer();
				}
			});
			$('#inner #tabledivbody tr').disableSelection();
				// section id za upisivanje u sql tabelu

			$('#inner #normal tr').each(function() {
				if (!($(this).attr('class')=='header')) {
					var id=($(this).children('td:first').children('a').attr('data-param'));
					id = id.substr(id.lastIndexOf("=")+1);
					id= 'sectionsid_'+id;
					$(this).attr('id',id);
				}
			});
			function sendOrderToServer() {
				var gpid=$('#inner #grupaproizvodaid').val();
				var link = 'plg_products/grupaproizvoda/move_product_in_group.php';
				var order = $('#inner #tabledivbody').sortable('serialize')+'&grupaproizvodaid='+gpid;
				$.ajax({
					type: 'POST',
					url: link,
					data: order,
					success: function(data) {}
				});
			}

            $("#inner .obrisi-proizvod").click(function() {
                var obrisiParams = 'obrisiParams='+$(this).attr("tag");
                $(this).parent().parent().remove();
                $.ajax({
                    url: "plg_products/grupaproizvoda/delete_product_from_group.php",
                    data: obrisiParams,
                    success: function(data) {
						var klasa = $(data).attr('class');
						toastr[klasa](data);
                    }
                });
            });


			$("#inner .naziv").click(function() {
                var param = $(this).attr('data-param');
				var gpid = $('#inner #grupaproizvodaid').val();
                $.ajax({
                    url: "plg_products/proizvod/modify.php",
                    data: param,
                    success: function(data) {
						$('.backdrop').css("display", "none").empty();
						$('.backdrop').css("display", "block").html(data);
						$('.chosen-select').chosen({width: "100%"});
						$('#inner .title-action #promeni').click(function() {
							modify('proizvodi',gpid);
						})
                    }
                });
			});
        };
    {/literal}
	</script>


<div id="content">
	<form name="editcategory" id="inner" action="modify_final.php" method="post" enctype="multipart/form-data">
		<input name="mode" type="hidden" id="mode" value="{$mode}">
		<div class="row wrapper  page-heading">
                <div class="col-lg-8">
                    <h2 id="modi_title"></h2>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
						<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i> {$PLG_SAVE}</div>
						<div class="btn btn-default close-modal" type="button"><i class="fa fa-times"></i>&nbsp;{$PLG_CLOSE}</div>
                    </div>
                </div>
			</div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="{if $active ne 3}active{/if}"><a data-toggle="tab" href="#tab-1"> {$PLG_INFO}</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2"> {$PLG_DESCRIPTION}</a></li>
                                <li class="{if $active eq 3}active{/if}"><a data-toggle="tab" href="#tab-3"> {$PLG_PRODUCTS}</a></li>
																{*<li class=""><a data-toggle="tab" href="#tab-4"> {$PLG_DISCOUNT}</a></li>*}
                            </ul>
							 <div class="tab-content">
                                <div id="tab-1" class="tab-pane {if $active ne 3}active{/if}">
                                    <div class="panel-body">
										<fieldset class="form-horizontal">
                                            <div class="form-group"><label class="col-sm-2 control-label">{$PLG_NAME}</label>
                                                <div class="col-sm-10"><input name="naziv" type="text" value="{$naziv}" class="form-control" size="40"></div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_PARENT}</label>
                                                <div class="col-sm-10">{$parentgrpCmb}</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_TEMPLATE}</label>
												<div class="col-sm-10">
													<select id="templateid" name="templateid" class="form-control">
														{html_options values=$template_val selected=$template_sel output=$template_out}
													</select>
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_STATUS}</label>
												<div class="col-sm-10">
													<select id="statusid" name="statusid" class="form-control">
														{html_options values=$status_val selected=$status_sel output=$status_out}
													</select>
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_IMAGE}</label>
												<div class="col-sm-6">
												   <input id="slika" name="slika" type="text" value="{$slika}"  class="form-control image">
												</div>
												<div class="col-sm-2">
												  <a class="btn btn-success" href="javascript:BrowseServer(this);"><i class="fa fa-plus-square-o" ></i> {$PLG_ADD}</a>
												</div>
												<div class="col-sm-2">
												  <a data-toggle="modal" data-target="#myModal7"><img class="image-title" src="{$slika}"  /><div class="overlay-icon"></div></a>
												</div>
											</div>

											<div class="form-group"><label class="col-sm-2 control-label">Opcija</label>

											<div class="col-sm-10">
												<div class="checkbox checkbox-inline checkbox-primary">
													<input type="checkbox" name="congroup" {if $congroup==1} checked {/if} >
													<label for="inlineCheckbox1"> Vezana grupa </label>
												</div>
												{*
												<div class="checkbox checkbox-inline checkbox-primary">
													<input type="checkbox" name="nlgroup" {if $nlgroup==1} checked {/if}>
													<label for="inlineCheckbox1"> {$PLG_NL}  </label>
												</div>
												<div class="checkbox checkbox-inline checkbox-primary">
													<input type="checkbox" name="kitgroup" {if $kitgroup==1} checked {/if} >
													<label for="inlineCheckbox1"> {$PLG_KIT} </label>
												</div>
												*}
											</div>


										</fieldset>
                                    </div>
                                </div>
								<div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <fieldset class="form-horizontal">
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_DESCRIPTION}</label>
                                                <div class="col-sm-10">
													<textarea id="opis" name="opis">{$opis}</textarea>
														<script type="text/javascript">
															{literal}
															CKEDITOR.replace('opis', {
																height: '150',
																width: '800'
															});
															{/literal}
														</script>
												</div>
                                            </div>
										</fieldset>
                                    </div>
                                </div>
								<div id="tab-3" class="tab-pane {if $active eq 3}active{/if}">
									<div class="panel-body">
                                        <fieldset class="form-horizontal">
											<div class="row">
												<div class="col-lg-12">
													<h2>{$PLG_}</h2>
												</div>
											</div>
											<div class="table-responsive">
											{if $table_not_empty} {html_table_advanced browseString=$tbl_browseString scriptName=$scriptName cnt_rows=$tbl_row_count rowOffset=$tbl_offset tr_attr=$tbl_tr_attributes td_attr=$tbl_td_attributes loop=$tbl_content cols=$tbl_cols_count tableheader=$tbl_header table_attr='cellspacing=0 class="index" id="normal"' message=$poruka cnt_all_rows=$tbl_all_rows_count } {else} {$PLG_NONE} {/if}
											</div>
										</fieldset>
									</div>
								</div>
								<div id="tab-4" class="tab-pane">
									<div class="panel-body">
										<fieldset class="form-horizontal">
											<div class="form-group"><label class="col-sm-12">{$PLG_PRODUCT_MODIFY_DISCOUNT_USERCATEGORY}</label></div>
												 {section name=pom loop=$cats_all}
												 {if $cats_all[pom].id ne 1}
												 <div class="form-group">
												 	<label class="col-sm-2 control-label">{$cats_all[pom].vrednost}</label>
													<div class="col-sm-2"><input type='text' class="form-control" size="3" name='cat{$cats_all[pom].id}' value='{$cats_all[pom].disvalue}'></div><div class="col-sm-2">%</div>
													<div class="col-sm-6">&nbsp;</div>
												</div>
												 {/if}
												 {/section}
										</fieldset>
									</div>
								</div>
							</div>

                        <input name="grupaproizvodaorder" type="hidden" id="grupaproizvodaorder" value="{$grupaproizvodaorder}">
                        <input name="grupaproizvodaid" type="hidden" id="grupaproizvodaid" value="{$grupaproizvodaid}">
                        <input name="type" type="hidden" id="type" value="{$type}">

						<div class="backdrop"></div>
        </form>
    </div>
