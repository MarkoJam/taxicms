<?php
/* Smarty version 3.1.32, created on 2023-04-05 12:18:19
  from 'C:\wamp\www\taxicms\templates\sections_default_system6.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642d4aebc9b5a6_76589323',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b0445b92af4cd306ec195fdbbb21bdea64fa41e6' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\sections_default_system6.tpl',
      1 => 1671542194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642d4aebc9b5a6_76589323 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
>

$( document ).ready(function() {
$('.video-wrap').each(function(event){

//  const fileUrl = <?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['slika'];?>
;
  const imgExtensions = ['jpg', 'png'];
  const videoExtensions = ['mkv', 'mp4', 'webm'];
  const name = '<?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][0]['slika'];?>
';
  const lastDot = name.lastIndexOf('.');

  const ext = name.substring(lastDot + 1);
	console.log(ext);

  if (imgExtensions.includes(ext)) {
    $(".video-container").hide(); // hide video preview
    $(".image-container").show();
  } else if (videoExtensions.includes(ext)) {
    $(".image-container").hide(); // hide image preview
    $(".video-container").show();
  }
});
});

<?php echo '</script'; ?>
>
<section class="system-area3">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2><?php echo $_smarty_tpl->tpl_vars['PLG_SECTION_HIGH']->value;?>
</h2>
      </div>
    </div>
  </div>
  <?php if ($_smarty_tpl->tpl_vars['data']->value['sections_all'][0]['slika'] != '') {?>
  <div class="video-container">
  	<video controls class="w-100">
    	<source src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][0]['slika'];?>
" type="video/mp4" />
  	</video>
	</div>
  <div class="system-area3-video image-container">
    <img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][0]['slika'];?>
" />
  </div>
  <?php } else { ?>
  <div class="system-area3-video">
    <?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][0]['shorthtml'];?>
</h3>
  </div>
  <?php }?>
</section>
<?php }
}
