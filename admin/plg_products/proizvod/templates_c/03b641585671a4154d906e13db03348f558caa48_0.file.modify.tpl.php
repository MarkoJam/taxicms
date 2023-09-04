<?php
/* Smarty version 3.1.32, created on 2019-10-04 22:29:50
  from 'C:\wamp\www\masine\admin\plg_products\proizvod\templates\modify.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5d97abbe2b8224_68105384',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '03b641585671a4154d906e13db03348f558caa48' => 
    array (
      0 => 'C:\\wamp\\www\\masine\\admin\\plg_products\\proizvod\\templates\\modify.tpl',
      1 => 1570220962,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d97abbe2b8224_68105384 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\masine\\common\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'C:\\wamp\\www\\masine\\common\\libs\\plugins\\function.html_table_advanced.php','function'=>'smarty_function_html_table_advanced',),));
echo '<script'; ?>
>

	function param_add() {
		$('#inner select, #inner input, #inner textarea').each(function() {
			if ($(this).attr('name') && !($(this).attr('name')=='mode')) {
				var name = $(this).attr('name');
				name = name.replace('[]','');
				$(this).attr('id', name);	
				var x1 = "#inner #"+name;
				var visible = $(this).css('visibility');
				if (visible=='hidden') 
				{
					var instance = CKEDITOR.instances[name];
					instance.updateElement();
					var val = instance.getData();
				}	
				else var val = $(x1).val();		
				param = param + "&" + name + "=" + val;
			}			
		})
		return param;
	}
	function modify_plugin() {
		$('.chosen-select').chosen({width: "100%"});
		// vezani dodatni resursi
		prepare_rows('img');	
		insert_row('img','images','files/Image/proizvod/user_uploads');
		prepare_rows('vid');		
		insert_row('vid');	
		prepare_rows('web');		
		insert_row('web');			
		prepare_rows('doc');	
		insert_row('doc','files','files/File/proizvod/user_uploads');		

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
			format_row();
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
			format_row();
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
	function format_row() {
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
		format_row();
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
						<li class=""><a data-toggle="tab" href="#tab-2"> <?php echo $_smarty_tpl->tpl_vars['PLG_DESCRIPTION']->value;?>
</a></li>
						<li class=""><a data-toggle="tab" href="#tab-3"> <?php echo $_smarty_tpl->tpl_vars['PLG_CON']->value;?>
</a></li>
						<li class=""><a data-toggle="tab" href="#tab-4"> <?php echo $_smarty_tpl->tpl_vars['PLG_IMAGE']->value;?>
</a></li>
						<li class=""><a data-toggle="tab" href="#tab-5"> <?php echo $_smarty_tpl->tpl_vars['PLG_COMPONENTS']->value;?>
</a></li>
						<li class=""><a data-toggle="tab" href="#tab-6"> <?php echo $_smarty_tpl->tpl_vars['PLG_COLORS']->value;?>
</a></li>				
						<li class=""><a data-toggle="tab" href="#tab-7"> <?php echo $_smarty_tpl->tpl_vars['PLG_EXT_RES']->value;?>
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
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_FORMAT']->value;?>
</label>
										<div class="col-sm-10">
											<select name="formatid" class="form-control">
												<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['format_val']->value,'selected'=>$_smarty_tpl->tpl_vars['format_sel']->value,'output'=>$_smarty_tpl->tpl_vars['format_out']->value),$_smarty_tpl);?>

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
									<?php if ((isset($_SESSION['WHOLESALE']) && $_SESSION['WHOLESALE'] == 1)) {?>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PRICE']->value;?>
</label>
										<div class="col-sm-10">
											<input name="cenaa" type="text" value="<?php echo $_smarty_tpl->tpl_vars['cenaa']->value;?>
" size="20" class="form-control">
										</div>
									</div>
									<?php }?>	
									<?php if ((isset($_SESSION['RETAIL']) && $_SESSION['RETAIL'] == 1)) {?>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PRICE_RETAIL']->value;?>
</label>
										<div class="col-sm-10">
											<input name="cenaamp" type="text" value="<?php echo $_smarty_tpl->tpl_vars['cenaamp']->value;?>
" size="20" class="form-control">
										</div>
									</div>
									<?php }?>		
									<?php if ((isset($_SESSION['WHOLESALE']) && $_SESSION['WHOLESALE'] == 1)) {?>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PRICEDOWN']->value;?>
</label>
										<div class="col-sm-10">
											<input name="cenab" type="text" value="<?php echo $_smarty_tpl->tpl_vars['cenab']->value;?>
" size="20" class="form-control">
										</div>
									</div>
									<?php }?>	
									<?php if ((isset($_SESSION['RETAIL']) && $_SESSION['RETAIL'] == 1)) {?>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PRICEDOWN_RETAIL']->value;?>
</label>
										<div class="col-sm-10">
											<input name="cenabmp" type="text" value="<?php echo $_smarty_tpl->tpl_vars['cenabmp']->value;?>
" size="20" class="form-control">
										</div>
									</div>
									<?php }?>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_WEIGHT']->value;?>
</label>
										<div class="col-sm-10">
										   <input name="tezina" type="text" value="<?php echo $_smarty_tpl->tpl_vars['tezina']->value;?>
" size="20" class="form-control">
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_UNIT']->value;?>
</label>
										<div class="col-sm-10">
										   <input name="jedinica" type="text" value="<?php echo $_smarty_tpl->tpl_vars['jedinica']->value;?>
" size="20" class="form-control">
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
									<?php echo $_smarty_tpl->tpl_vars['tr_td_karakteristike']->value;?>


								</fieldset>
							</div>
						</div>
						<div id="tab-3" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<?php if ((isset($_SESSION['CONNECTED_GROUP']) && $_SESSION['CONNECTED_GROUP'] == 1)) {?>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_GROUP']->value;?>
</label>
										<div class="col-sm-10">
											<select size="5"  name="grupaproizvodaids" class="chosen-select">
												<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['vezanegrupe_val']->value,'selected'=>$_smarty_tpl->tpl_vars['vezanegrupe_sel']->value,'output'=>$_smarty_tpl->tpl_vars['vezanegrupe_out']->value),$_smarty_tpl);?>

											</select>
										</div>
									</div>
									<?php }?>
									<?php if ((isset($_SESSION['KIT']) && $_SESSION['KIT'] == 1)) {?>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_KIT']->value;?>
</label>
										<div class="col-sm-10">
											<select size="5"  name="grupaproizvodaids2" class="chosen-select">
												<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['kitgrupe_val']->value,'selected'=>$_smarty_tpl->tpl_vars['kitgrupe_sel']->value,'output'=>$_smarty_tpl->tpl_vars['kitgrupe_out']->value),$_smarty_tpl);?>

											</select>
										</div>
									</div>
									<?php }?>
								</fieldset>
							</div>
						</div>
						<div id="tab-4" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_IMAGE']->value;?>
</label>
										<div class="col-sm-6">
										   <input id="slika" name="slika" type="text" value="<?php echo $_smarty_tpl->tpl_vars['slika']->value;?>
" size="50" class="form-control">
										</div>
										<div class="col-sm-2">
										  <a class="btn btn-success" href="javascript:BrowseServer(this);"><i class="fa fa-plus-square-o" ></i> <?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
</a>
										</div>
										<div class="col-sm-2">
										  <img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['slika']->value;?>
" style="height:auto; width: 100%;" />
										</div>										
									</div>
									
								</fieldset>
							</div>
						</div>	
						<div id="tab-5" class="tab-pane ">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="table-responsive">
										<div class="table-responsive" id='components'>
											<?php echo smarty_function_html_table_advanced(array('filter'=>$_smarty_tpl->tpl_vars['filter']->value,'content'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'cnt_all_rows'=>$_smarty_tpl->tpl_vars['tbl_all_rows_count']->value,'browseString'=>$_smarty_tpl->tpl_vars['tbl_browseString']->value,'scriptName'=>$_smarty_tpl->tpl_vars['scriptName']->value,'cnt_rows'=>$_smarty_tpl->tpl_vars['tbl_row_count']->value,'rowOffset'=>$_smarty_tpl->tpl_vars['tbl_offset']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['tbl_tr_attributes']->value,'td_attr'=>$_smarty_tpl->tpl_vars['tbl_td_attributes']->value,'loop'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'cols'=>$_smarty_tpl->tpl_vars['tbl_cols_count']->value,'tableheader'=>$_smarty_tpl->tpl_vars['tbl_header']->value,'exportlinks'=>$_smarty_tpl->tpl_vars['tbl_show_export_links']->value,'table_attr'=>'cellspacing=0 class="index" id="normal"','message'=>$_smarty_tpl->tpl_vars['poruka']->value),$_smarty_tpl);?>

										</div>
									
									</div>
								</fieldset>
							</div>
						</div>
						<div id="tab-6" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="form-group">
										<div  class="col-sm-2">									
											<label class="control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_COLORS']->value;?>
</label>	
										</div>	
										
										<div  class="col-sm-2">
											<label class="control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_CODE']->value;?>
</label>	
										</div>								
										<?php if ((isset($_SESSION['WHOLESALE']) && $_SESSION['WHOLESALE'] == 1)) {?>																				
										<div  class="col-sm-2">
											<label class="control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PRICE']->value;?>
</label>	
										</div>	
										<div  class="col-sm-1">
											<label class=" control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PRICEDOWN']->value;?>
</label>	
										</div>	
										<?php }?>
										<?php if ((isset($_SESSION['RETAIL']) && $_SESSION['RETAIL'] == 1)) {?>										
										<div  class="col-sm-1">
											<label class="control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PRICE_RETAIL']->value;?>
</label>	
										</div>	
										<div  class="col-sm-1">
											<label class="control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PRICEDOWN_RETAIL']->value;?>
</label>	
										</div>
										<?php }?>	
										<div  class="col-sm-1">
											<label class="control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_QUANTITY']->value;?>
</label>	
										</div>											
									</div>								
									<?php
$__section_pom_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['velicine']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_0_total = $__section_pom_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_0_total !== 0) {
for ($__section_pom_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_0_iteration <= $__section_pom_0_total; $__section_pom_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>	
									<div class="form-group">
										<div  class="col-sm-2">	
											<div  class="checkbox checkbox-primary">
										
											<input type="checkbox" class="write_title" id="vel<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" name="vel<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" value="" <?php if ($_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['exist']) {?>checked<?php }?> /><label for="checkbox"> <?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['naziv'];?>
	/ <?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['opis'];?>
</label> 
											</div>
										</div>	
										<div class="col-sm-2">
											<input type="text" class="form-control" id="sifra<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" name="sifra<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['prvelicine']['sifra'];?>
"  />													
										</div>			
										<?php if ((isset($_SESSION['WHOLESALE']) && $_SESSION['WHOLESALE'] == 1)) {?>										
										<div class="col-sm-2">
											<input type="text" class="form-control" id="cenaa<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" name="cenaa<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['prvelicine']['cenaa'];?>
"  />													
										</div>											
										<div class="col-sm-1">
											<input type="text" class="form-control" id="cenab<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" name="cenab<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['prvelicine']['cenab'];?>
"  />													
										</div>
										<?php }?>	
										<?php if ((isset($_SESSION['RETAIL']) && $_SESSION['RETAIL'] == 1)) {?>
										<div class="col-sm-1">
											<input type="text" class="form-control" id="cenaamp<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" name="cenaamp<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['prvelicine']['cenaamp'];?>
"  />													
										</div>											
										<div class="col-sm-1">
											<input type="text" class="form-control" id="cenabmp<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" name="cenabmp<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['prvelicine']['cenabmp'];?>
"  />													
										</div>	
										<?php }?>
										<div class="col-sm-1">
											<input type="text" class="form-control" id="kolicina<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" name="kolicina<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['velicinaid'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['velicine']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['prvelicine']['kolicina'];?>
"  />													
										</div>											
									</div>	
									<?php
}
}
?>
								</fieldset>
							</div>
						</div>
						<div id="tab-7" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="table-responsive">
									<?php echo $_smarty_tpl->tpl_vars['img_rows']->value;?>
		
										<div class="hr-line-dashed"></div>
									<?php echo $_smarty_tpl->tpl_vars['vid_rows']->value;?>
	
										<div class="hr-line-dashed"></div>
									<?php echo $_smarty_tpl->tpl_vars['web_rows']->value;?>
	
										<div class="hr-line-dashed"></div>
									<?php echo $_smarty_tpl->tpl_vars['doc_rows']->value;?>
										

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
