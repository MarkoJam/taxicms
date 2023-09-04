<?php
/* Smarty version 3.1.32, created on 2023-04-05 12:18:19
  from 'C:\wamp\www\taxicms\templates\sections_default_system3.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642d4aeb4cf750_27295352',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e9e17c6c09f64bf81c1ebbf59f998735197fab54' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\sections_default_system3.tpl',
      1 => 1666778094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642d4aeb4cf750_27295352 (Smarty_Internal_Template $_smarty_tpl) {
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
<section class="system-area3 video-wrap">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][0]['shorthtml'];?>

      </div>
    </div>
  </div>
	<div class="video-container">
  	<video controls class="w-100">
    	<source src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][0]['slika'];?>
" type="video/mp4" />
  	</video>
	</div>
  <div class="system-area3-video image-container">
    <?php echo $_smarty_tpl->tpl_vars['data']->value['sections_all'][0]['slika'];?>

  </div>
</section>
<?php }
}
