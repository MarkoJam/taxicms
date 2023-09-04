<?php
/* Smarty version 3.1.32, created on 2023-09-04 08:25:28
  from 'C:\wamp\www\taxicms\templates\module_details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_64f5785815c720_22226362',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c4e29113cb37a8d4e95789527564f30007a74e55' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\module_details.tpl',
      1 => 1693481422,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64f5785815c720_22226362 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['plugin_view']->value == "module_details") {?>
	<section class="news-details-area">
		<div class="container">
			<div class="row">
				<div class="path path-news">
					<ul>
						<li><a href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['lang']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['PLG_LINK_MODULE']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['PLG_MODULES']->value;?>
</a></li>
						<li><?php echo $_smarty_tpl->tpl_vars['module_detail']->value['header'];?>
</li>
					</ul>
				</div>
			</div>
						<div class="row">
				<div class="col-lg-6 col-md-6 col-6">
					<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['module_detail']->value['slika'];?>
" class="mb-10 w-100" />
				</div>	
				<div class="col-lg-6 col-md-6 col-6">
					<p><?php echo $_smarty_tpl->tpl_vars['PLG_MENU_OPTIONS']->value;?>
</p>
					<?php
$__section_pom_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['conmodule']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_0_total = $__section_pom_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_0_total !== 0) {
for ($__section_pom_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_0_iteration <= $__section_pom_0_total; $__section_pom_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>
						<div class="row">
							<div class="col-lg-4 col-md-4 col-4">
								<div class="box-text"><a href='<?php echo $_smarty_tpl->tpl_vars['conmodule']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['link_print_dt'];?>
'><?php echo $_smarty_tpl->tpl_vars['conmodule']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['header'];?>
</a></div>
							</div>
							<div class="col-lg-8 col-md-8 col-8">
								<small><i><?php echo $_smarty_tpl->tpl_vars['conmodule']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['shorthtml'];?>
</i></small>
							</div>
						</div>
					<?php
}
}
?>
				</div>
				<?php echo $_smarty_tpl->tpl_vars['module_detail']->value['html'];?>
				
			</div>			

			<?php if ($_smarty_tpl->tpl_vars['module_detail']->value['img_rows'] != '') {?>
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="g-title">
							<h2><?php echo $_smarty_tpl->tpl_vars['PLG_VIEW']->value;?>
</h2>
						</div>
						<div id="gallery" class="row content-gallery">
							<?php
$__section_cnt_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['images']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_1_total = $__section_cnt_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_1_total !== 0) {
for ($__section_cnt_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = 0; $__section_cnt_1_iteration <= $__section_cnt_1_total; $__section_cnt_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
?>
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 galerija-wrap">
									<div class="galerija">
										<a class="example-image-link" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['images']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)];?>
" data-lightbox="example-1">
											<div class="image-wrap">
												<img class="example-image" alt="" src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['images_thumb']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)];?>
">
											</div>
										</a>
									</div>
								</div>
							<?php
}
}
?>
						</div>
					</div>
				</div>
			<?php }?>
			<?php echo $_smarty_tpl->tpl_vars['module_detail']->value['vid_rows'];?>

			<?php echo $_smarty_tpl->tpl_vars['module_detail']->value['doc_rows'];?>

			<?php echo $_smarty_tpl->tpl_vars['module_detail']->value['web_rows'];?>

		</div>	
    </section>
<?php }
}
}
