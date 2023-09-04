<?php
/* Smarty version 3.1.32, created on 2023-04-03 13:44:17
  from 'C:\wamp\www\taxicms\admin\plg_products\proizvod\templates\modify.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642abc115152c9_17597148',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e74d9786b314ef4e87113aea7673d66848aa49f3' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\admin\\plg_products\\proizvod\\templates\\modify.tpl',
      1 => 1666608896,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642abc115152c9_17597148 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\taxicms\\common\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
echo '<script'; ?>
 type="text/javascript" src="CKeditor/ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>


	function modify_plugin() {
		$('.chosen-select').chosen({display_selected_options:false,width: "100%"}).next().addClass('up');
	// vezani dodatni resursi
		prepare_rows('img');
		insert_row('img','1','');
		prepare_rows('vid');
		insert_row('vid');
		prepare_rows('web');
		insert_row('web');
		prepare_rows('doc');
		insert_row('doc','2','File');

	};
	function input_row() {
		var new_row=$('#components tbody tr:last').clone();
		$('.table-responsive select').change(function() {
			var cnid = $('.table-responsive #vproizvodid1 option:selected').val();
			var nid = $('#proizvodid').val();
			var mode = $('#mode').val();
			var link = window.folder+"/"+'insert_vproizvod.php';
			var param = 'vproizvodid='+cnid+'&proizvodid='+nid+'&mode='+mode;
			alert (param);
			$.ajax({
				type: "POST",
				url: link,
				data: param,
				async: false,
				success: function(data) {
					//var klasa = $(data).attr('class');
					//toastr[klasa](data);
					$('.table-responsive #input_name:last').text($('.table-responsive #vproizvodid1 option:selected').text());
					$('.table-responsive #delete_vproizvod').show();
					$('.table-responsive #delete_vproizvod').attr('data-param',param);
					$('.table-responsive #kolicina').attr('data-param',param);
					delete_row();
					$('.table-responsive #kolicina').show();
					$('.table-responsive #cena').show();
					$('.table-responsive #vrednost').show();
					var cena = data;
					$('.table-responsive #cena:last').text(cena);
				}
			});
			$('#components tbody').append(new_row);
			input_row() ;
			countries_row();
			change_quantity();
		})
	};
	function delete_row() {
		$('.table-responsive #delete_vproizvod').click(function() {
			link = window.folder+"/"+'delete_vproizvod.php';
			var param = $(this).attr('data-param');
			$.ajax({
				type: "POST",
				url: link,
				data: param,
				async: false,
				success: function(data) {
					//var klasa = $(data).attr('class');
					//toastr[klasa](data);
				}
			});
			$(this).parent().parent().remove();
		})
	}
	function change_quantity() {
		$('.table-responsive #kolicina').change(function() {
			link = window.folder+"/"+'change_quantity.php';
			var kol = $(this).val();
			var param = $(this).attr('data-param')+'&kolicina=' + kol;
			var cena = $(this).parent().parent().find('#cena').text();
			var vr = cena*kol;
			$(this).parent().parent().find('#vrednost').val(vr);
			suma();
			countries_row();
			$.ajax({
				type: "POST",
				url: link,
				data: param,
				async: false,
				success: function(data) {
					//var klasa = $(data).attr('class');
					//toastr[klasa](data);
				}
			});
		})
	}
	function suma() {
		var suma=0;
		$('.table-responsive #vrednost').each(function() {
			suma=suma + Number($(this).val());
		})
		$('.table-responsive #suma').val(suma);
	}
	function countries_row() {
		$('#components input,p').css({'text-align':'right'});
		$('#components input').each(function() {
			var vr=Number($(this).val());
			vr = vr.toFixed(2);
			$(this).val(vr);
		})
		$('#components p').each(function() {
			var vr=Number($(this).text());
			vr = vr.toFixed(2);
			$(this).text(vr);
		})
	}
	$(document).ready(function() {
		delete_row();
		input_row();
		change_quantity();
		suma();
		countries_row();
		$('.table-responsive #pager').hide();
	})

<?php echo '</script'; ?>
>
<div id="content">
	<form id='inner' name="editproizvod" action="modify_final.php" method="post" enctype="multipart/form-data">
	<input name="mode" type="hidden" id="mode" value="<?php echo $_smarty_tpl->tpl_vars['mode']->value;?>
">
	<div class="row wrapper  page-heading">
		<div class="col-lg-8">
			<h2 id="modi_title"></h2>
			<?php if ($_smarty_tpl->tpl_vars['proizvodnaziv']->value) {?><h2><?php echo $_smarty_tpl->tpl_vars['PLG_BASIC_PRODUCT']->value;?>
 : <?php echo $_smarty_tpl->tpl_vars['proizvodnaziv']->value;?>
</h2><?php }?>
		</div>
		<div class="col-lg-4">
			<div class="title-action">
				<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i> <?php echo $_smarty_tpl->tpl_vars['PLG_SAVE']->value;?>
</div>
				<div class="btn btn-default close-modal" type="button"><i class="fa fa-times"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_CLOSE']->value;?>
</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="tabs-container">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab-1"> <?php echo $_smarty_tpl->tpl_vars['PLG_INFO']->value;?>
</a></li>
						<li class=""><a data-toggle="tab" href="#tab-2">
						SEO</a></li>
						<li class=""><a data-toggle="tab" href="#tab-3"> <?php echo $_smarty_tpl->tpl_vars['PLG_DESCRIPTION']->value;?>
</a></li>
						<li class=""><a data-toggle="tab" href="#tab-4"> <?php echo $_smarty_tpl->tpl_vars['PLG_CARACTERISTICS']->value;?>
</a></li>
						<li class=""><a data-toggle="tab" href="#tab-5"> <?php echo $_smarty_tpl->tpl_vars['PLG_IMAGE']->value;?>
</a></li>
						<li class=""><a data-toggle="tab" href="#tab-6"> <?php echo $_smarty_tpl->tpl_vars['PLG_EXT_RES']->value;?>
</a></li>
					</ul>
					 <div class="tab-content">
						<div id="tab-1" class="tab-pane active">
							<div class="panel-body">

								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_TYPE']->value;?>
</label>
										<div class="col-sm-10 tip-label"><?php echo $_smarty_tpl->tpl_vars['tipproizvodanaziv']->value;?>
</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_STATUS']->value;?>
</label>
										<div class="col-sm-10">
											<select name="statusid" class="form-control">
												<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['status_val']->value,'selected'=>$_smarty_tpl->tpl_vars['status_sel']->value,'output'=>$_smarty_tpl->tpl_vars['status_out']->value),$_smarty_tpl);?>

											</select>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
</label>
										<div class="col-sm-10">
											<input name="naziv" type="text" value="<?php echo $_smarty_tpl->tpl_vars['naziv']->value;?>
" size="60" class="form-control">
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_CODE']->value;?>
</label>
										<div class="col-sm-10">
											<input name="sifra" type="text" value="<?php echo $_smarty_tpl->tpl_vars['sifra']->value;?>
" size="40" class="form-control">
										</div>
									</div>
																		<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_WEIGHT']->value;?>
</label>
										<div class="col-sm-10">
										   <input name="tezina" type="text" value="<?php echo $_smarty_tpl->tpl_vars['tezina']->value;?>
" size="20" class="form-control">
										</div>
									</div>

									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PRICE']->value;?>
</label>
										<div class="col-sm-10">
											<input name="cenaa" type="text" value="<?php echo $_smarty_tpl->tpl_vars['cenaa']->value;?>
" size="20" class="form-control">
										</div>
									</div>

									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PRICEDOWN']->value;?>
</label>
										<div class="col-sm-10">
											<input name="cenab" type="text" value="<?php echo $_smarty_tpl->tpl_vars['cenab']->value;?>
" size="20" class="form-control">
										</div>
									</div>
																		<div class="form-group"><label class="col-sm-2 control-label">Povezane grupe proizvoda</label>
										<div class="col-sm-10">
											<div>
												<select size="5"  name="grupaproizvodaid[]" class="chosen-select up">
													<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['vezanegrupe_val']->value,'selected'=>$_smarty_tpl->tpl_vars['vezanegrupe_sel']->value,'output'=>$_smarty_tpl->tpl_vars['vezanegrupe_out']->value),$_smarty_tpl);?>

												</select>
											</div>
										</div>
									</div>
																	<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_MANUFACTURER']->value;?>
</label>
										<div class="col-sm-10">
											<select id="proizvodjacid" name="proizvodjacid" class="form-control">
												<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['proizvodj_val']->value,'selected'=>$_smarty_tpl->tpl_vars['proizvodj_sel']->value,'output'=>$_smarty_tpl->tpl_vars['proizvodj_out']->value),$_smarty_tpl);?>

											</select>
										</div>
									</div>
								</fieldset>
							</div>
						</div>
						<div id="tab-2" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label">Opis</label>
										<div class="col-sm-10">
											<input name="napomenaadd" type="text" value="<?php echo $_smarty_tpl->tpl_vars['napomenaadd']->value;?>
"  class="form-control">
										</div>
									</div>

									<div class="form-group"><label class="col-sm-2 control-label">Ključne reči</label>
										<div class="col-sm-10">
											<input name="napomena" type="text" value="<?php echo $_smarty_tpl->tpl_vars['napomena']->value;?>
"  class="form-control">
										</div>
									</div>

								</fieldset>
							</div>
						</div>
						<div id="tab-3" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_SHORTDESCRIPTION']->value;?>
</label>
										<div class="col-sm-10">
											<textarea id="kratak_opis" name="kratak_opis"><?php echo $_smarty_tpl->tpl_vars['kratak_opisCK']->value;?>
</textarea>
											<?php echo '<script'; ?>
 type="text/javascript">
											
												CKEDITOR.replace( 'kratak_opis',
													 { height:'100',
													   width:'700'
													  });
											
											<?php echo '</script'; ?>
>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_DESCRIPTION']->value;?>
</label>
										<div class="col-sm-10">
											<textarea id="opis" name="opis"><?php echo $_smarty_tpl->tpl_vars['opisCK']->value;?>
</textarea>
											<?php echo '<script'; ?>
 type="text/javascript">
											
												CKEDITOR.replace( 'opis',
													 { height:'250',
													   width:'700'
													  });
											
											<?php echo '</script'; ?>
>
										</div>
									</div>

								</fieldset>
							</div>
						</div>
						<div id="tab-4" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<?php echo $_smarty_tpl->tpl_vars['tr_td_karakteristike']->value;?>

								</fieldset>
							</div>
						</div>
						<div id="tab-5" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_IMAGE']->value;?>
</label>
										<div class="col-sm-6">
										   <input id="slika" name="slika" type="text" value="<?php echo $_smarty_tpl->tpl_vars['slika']->value;?>
"  class="form-control">
										</div>
										<div class="col-sm-2">
										  <a class="btn btn-success" href="javascript:BrowseServer(this);"><i class="fa fa-plus-square-o" ></i> <?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
</a>
										</div>
										<div class="col-sm-2">
										  <img class="image responsive" src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['slika']->value;?>
" style="height:auto; width: 100%;" />
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label">Slika mouse over</label>
										<div class="col-sm-6">
										   <input id="slikaover" name="slikaover" type="text" value="<?php echo $_smarty_tpl->tpl_vars['slikaover']->value;?>
"  class="form-control">
										</div>
										<div class="col-sm-2">
										  <a class="btn btn-success" href="javascript:BrowseServerSlika(this);"><i class="fa fa-plus-square-o" ></i> <?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
</a>
										</div>
										<div class="col-sm-2">
										  <img class="imageover responsive"  src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['slikaover']->value;?>
" style="height:auto; width: 100%;" />
										</div>
									</div>

								</fieldset>
							</div>
						</div>
						<div id="tab-6" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="table-responsive">
									<?php echo $_smarty_tpl->tpl_vars['img_rows']->value;?>

																		</div>
								</fieldset>
							</div>
						</div>
					</div>
				</div>
			</div>

			<input name="proizvodid" type="hidden" id="proizvodid" value="<?php echo $_smarty_tpl->tpl_vars['proizvodid']->value;?>
" />
			<input name="oem" type="hidden"  value="<?php echo $_smarty_tpl->tpl_vars['oem']->value;?>
" />
			<input name="kolicina" type="hidden"  value="<?php echo $_smarty_tpl->tpl_vars['kolicina']->value;?>
" />
			<input name="tipproizvodaid" type="hidden" id="tipproizvodaid" value="<?php echo $_smarty_tpl->tpl_vars['tipproizvodaid']->value;?>
" />
			<input name="order" type="hidden" id="order" value="<?php echo $_smarty_tpl->tpl_vars['order']->value;?>
" />
			<input name="grpproizbackid" type="hidden" id="grpproizbackid" value="<?php echo $_REQUEST['grpproizbackid'];?>
" />
		</div>


	</form>
</div>
<?php }
}
