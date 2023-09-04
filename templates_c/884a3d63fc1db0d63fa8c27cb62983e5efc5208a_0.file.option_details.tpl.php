<?php
/* Smarty version 3.1.32, created on 2023-09-04 14:45:47
  from 'C:\wamp\www\taxicms\templates\option_details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_64f5d17b4877c0_85502381',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '884a3d63fc1db0d63fa8c27cb62983e5efc5208a' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\option_details.tpl',
      1 => 1693477959,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64f5d17b4877c0_85502381 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['plugin_view']->value == "option_details") {?>
	<section class="news-details-area">
		<div class="container">
			<div class="row">
				<div class="path path-news">
					<ul>
						<li><a href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['lang']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['PLG_LINK_OPTIONS']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['PLG_OPTIONS']->value;?>
</a></li>
						<li><?php echo $_smarty_tpl->tpl_vars['option_detail']->value['header'];?>
</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="gp-title">
						<h2><?php echo $_smarty_tpl->tpl_vars['option_detail']->value['header'];?>
</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-12">
					<?php echo $_smarty_tpl->tpl_vars['option_detail']->value['html'];?>

				</div>
			</div>			

			<?php if ($_smarty_tpl->tpl_vars['option_detail']->value['img_rows'] != '') {?>
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="g-title">
							<h2><?php echo $_smarty_tpl->tpl_vars['PLG_VIEW']->value;?>
</h2>
						</div>
						<div id="gallery" class="row content-gallery">
							<?php
$__section_cnt_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['images']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_0_total = $__section_cnt_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_0_total !== 0) {
for ($__section_cnt_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = 0; $__section_cnt_0_iteration <= $__section_cnt_0_total; $__section_cnt_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
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
			<?php echo $_smarty_tpl->tpl_vars['option_detail']->value['vid_rows'];?>

			<?php echo $_smarty_tpl->tpl_vars['option_detail']->value['doc_rows'];?>

			<?php echo $_smarty_tpl->tpl_vars['option_detail']->value['web_rows'];?>

		</div>	
    </section>
<?php }
}
}
