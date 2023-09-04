<!DOCTYPE html>
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

	  <link href="{$ROOT_WEB}admin/css/admin.min.css" rel="stylesheet">

   </head>
   <body>
      <div id="wrapper">
         <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
               <ul class="nav metismenu" id="side-menu">
                  <li class="nav-header">
                     <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"><a data-folder="plg_profile" data-param=""><strong class="font-bold">{$PLG_USER}</strong></a></span>
						{*<span class="text-muted text-xs block">{$PLG_EMAIL} <b class="caret"></b></span> </span> </a>*}
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                           <li><a data-folder="plg_profile" data-param="">{$PLG_PROFILE}</a></li>
                           <li class="divider"></li>
                           <li><a href='index.php?action=logout'>{$PLG_LOGOUT}</a></li>
                        </ul>
                     </div>
					</li>
					<li class="active"><a data-folder="plg_dashboard" data-param=""><i class='fa fa-th-large'></i><span>{$PLG_DASHBOARD}</span></a></li>

                  {$admin_tree}

				  <li><a href="javascript:BrowseFileServer(this);"><i class='fa fa-file-text-o'></i><span>{$PLG_FILEMANAGER}</span></a></li>
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
                        <span class="m-r-sm text-muted welcome-message">{$PLG_WELCOME} / <b>{$local_language}</b></span>
                     </li>
                     <li>
                        <a href='index.php?action=logout'>
                        <i class="fa fa-sign-out"></i>{$PLG_LOGOUT}
                        </a>
                     </li>
                  </ul>
               </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
               <div class="col-lg-10">
                  <h2 id='title'>{$PLG_MENU_DASHBOARD}</h2>
                  <ol class="breadcrumb">
                     <li>
                        <a href="index.php">{$PLG_MAIN_PAGE}</a>
                     </li>
                     <li class="active">
                        <strong id='title2'>{$PLG_MENU_DASHBOARD}</strong>
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
									 {$horizontalNavigation}
								  </ul>
							   </div>
                        </div>
                        <div class="ibox-content2" id='group-left'>
							   <div id="ProductTreeMenu">
									 <div style="clear:both" id="grupaProizvodaNav" class="navigation">
										{$grpNavigation}
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
	 {section name=pom loop=$msg_id}
		<div id='{$msg_id[pom]}'>{$msg_txt[pom]}</div>
	{/section}
	  </div>

      <script src="{$ROOT_WEB}admin/js/main.min.js"></script>
      <script src="{$ROOT_WEB}admin/js/index.js" type="text/javascript"></script>

   </body>
