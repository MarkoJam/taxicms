<?php
/* Smarty version 3.1.32, created on 2023-04-03 13:28:33
  from 'C:\wamp\www\taxicms\admin\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642ab861124fd1_79202399',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a2a6feadeb73219f3acf3d1325ab1dd0f50026a1' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\admin\\templates\\index.tpl',
      1 => 1666177686,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642ab861124fd1_79202399 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
   <head>
      <title>Administration - CMS Studio</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv='cache-control' content='no-cache'>
		<meta http-equiv='expires' content='0'>
		<meta http-equiv='pragma' content='no-cache'>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">

	  <link href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
admin/css/admin.min.css" rel="stylesheet">

   </head>
   <body>
      <div id="wrapper">
         <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
               <ul class="nav metismenu" id="side-menu">
                  <li class="nav-header">
                     <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"><a data-folder="plg_profile" data-param=""><strong class="font-bold"><?php echo $_smarty_tpl->tpl_vars['PLG_USER']->value;?>
</strong></a></span>
						                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                           <li><a data-folder="plg_profile" data-param=""><?php echo $_smarty_tpl->tpl_vars['PLG_PROFILE']->value;?>
</a></li>
                           <li class="divider"></li>
                           <li><a href='index.php?action=logout'><?php echo $_smarty_tpl->tpl_vars['PLG_LOGOUT']->value;?>
</a></li>
                        </ul>
                     </div>
					</li>
					<li class="active"><a data-folder="plg_dashboard" data-param=""><i class='fa fa-th-large'></i><span><?php echo $_smarty_tpl->tpl_vars['PLG_DASHBOARD']->value;?>
</span></a></li>

                  <?php echo $_smarty_tpl->tpl_vars['admin_tree']->value;?>


				  <li><a href="javascript:BrowseFileServer(this);"><i class='fa fa-file-text-o'></i><span><?php echo $_smarty_tpl->tpl_vars['PLG_FILEMANAGER']->value;?>
</span></a></li>
               </ul>
            </div>
         </nav>
         <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
               <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                  <div class="navbar-header">
                     <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

                  </div>
                  <div class="navbar-header">
                     <button type="button" class="minimalize-styl-2 btn btn-primary " id="cashe"><i class="fa fa-refresh"></i> </button>
                  </div>
                  <ul class="nav navbar-top-links navbar-right">
                     <li>
                        <span class="m-r-sm text-muted welcome-message"><?php echo $_smarty_tpl->tpl_vars['PLG_WELCOME']->value;?>
 / <b><?php echo $_smarty_tpl->tpl_vars['local_language']->value;?>
</b></span>
                     </li>
                     <li>
                        <a href='index.php?action=logout'>
                        <i class="fa fa-sign-out"></i><?php echo $_smarty_tpl->tpl_vars['PLG_LOGOUT']->value;?>

                        </a>
                     </li>
                  </ul>
               </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
               <div class="col-lg-10">
                  <h2 id='title'><?php echo $_smarty_tpl->tpl_vars['PLG_MENU_DASHBOARD']->value;?>
</h2>
                  <ol class="breadcrumb">
                     <li>
                        <a href="index.php"><?php echo $_smarty_tpl->tpl_vars['PLG_MAIN_PAGE']->value;?>
</a>
                     </li>
                     <li class="active">
                        <strong id='title2'><?php echo $_smarty_tpl->tpl_vars['PLG_MENU_DASHBOARD']->value;?>
</strong>
                     </li>
                  </ol>
               </div>
               <div class="col-lg-2">
               </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
               <div class="row">
                  <div id="left" class="col-lg-3" style="display:none;">
                     <div class="ibox float-e-margins">
                        <div class="ibox-title">
							<h5></h5>
                           <div class="ibox-tools">
                              <a class="collapse-link">
                              <i class="fa fa-chevron-up"></i>
                              </a>
                              <a class="close-link">
                              <i class="fa fa-times"></i>
                              </a>
                           </div>
                        </div>

                        <div class="ibox-content1" id='page-left'>
							   <div id="PageNavigation-Horizontal">
								  <ul>
									 <?php echo $_smarty_tpl->tpl_vars['horizontalNavigation']->value;?>

								  </ul>
							   </div>
                        </div>
                        <div class="ibox-content2" id='group-left'>
							   <div id="ProductTreeMenu">
									 <div style="clear:both" id="grupaProizvodaNav" class="navigation">
										<?php echo $_smarty_tpl->tpl_vars['grpNavigation']->value;?>

									 </div>
							   </div>
                        </div>

                     </div>
                  </div>
                  <div id="right" class="col-lg-9">
                  </div>
               </div>
            </div>
            <div class="footer">
               <div class="pull-right">
               </div>
               <div>
                  Powered by <strong>CMS studio</strong>
               </div>
               <div class="backdrop"><div class="spiner"></div></div>
            </div>
         </div>
      </div>

	 <div id="msg" style="display:none;">
	 <?php
$__section_pom_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['msg_id']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_0_total = $__section_pom_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_0_total !== 0) {
for ($__section_pom_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_0_iteration <= $__section_pom_0_total; $__section_pom_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>
		<div id='<?php echo $_smarty_tpl->tpl_vars['msg_id']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)];?>
'><?php echo $_smarty_tpl->tpl_vars['msg_txt']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)];?>
</div>
	<?php
}
}
?>
	  </div>

      <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
admin/js/main.min.js"><?php echo '</script'; ?>
>
      <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
admin/js/index.js" type="text/javascript"><?php echo '</script'; ?>
>

   </body>
<?php }
}
