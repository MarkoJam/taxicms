<?php
/* Smarty version 3.1.32, created on 2023-10-17 09:25:24
  from 'C:\wamp\www\taxicms\templates\additional-style.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_652e36e4623df1_82297009',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ad4a1202230f843bb5d110787f6952ea794682af' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\additional-style.tpl',
      1 => 1695127639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_652e36e4623df1_82297009 (Smarty_Internal_Template $_smarty_tpl) {
?><style>

/* PARTS: */

img{
    border-radius: 5px;
}

/* TOP: -------------------------------------------------------- */

/* .wrapper{
} */

/* .header-wrapper-edit{
    height:auto;
} */

.header-middle{
    background: #cae6f199;
    background-image: url(./images/kocka.png),url(./images/kocka-right.png);
    background-repeat: no-repeat, no-repeat;
    background-position: left, right;
}

.navbar-default-edit{
    /* background-image: linear-gradient(#a5cbf1, #e0effa); old */
    background-image: linear-gradient(#d0deed, #73a9d1);
    /* box-shadow: 2px 1px 6px 2px #888888; old */
    box-shadow: 2px 1px 6px 2px #4a3f3f;
    border-radius: 10px;
}

/* Navigation: */
.dropdown-menu{
    width:auto;
    background: rgba(226, 237, 243, 0.78);
    border-radius: 7px;
    left:0;
}
.submenu-nav:before, .dropdown-menu:before{
    border-bottom: none;
}
.header-navigation .main-nav > li > a:hover {
    color: #e4f4fd;
}
.submenu-nav-link:hover, .dropdown-item:hover {
    color: #0a6eef;
    background-color: transparent;
}

/* MIDDLE: ------------------------------------------------------------------------- */

.main-content{
    background-image: url(http://localhost/taxicms/images/background-section.png);
}

/* Social icons: */
.social-icons a div, .social-icons div{
    background: #0086e975;
    border-radius: 5px;
}
.social-icons a div:hover, .social-icons div:hover{
    background: #269aefc7;
}

/* Section: */
.news-area.page-top .container .row div{
    margin-bottom: 10px;
}

#content .container .row{
    border-radius: 5px !important;
}


/* BOTTOM: ----------------------------------------------------------------------- */

.footer-area{
    background-image: linear-gradient(#307cb5,#31607e);
    box-shadow: 4px 2px 9px 2px #000000;
}



/* -------------------------------------------------------------------------------- */
/* -------------------------------------------------------------------------------- */

/* MEDIA QUERY: */
@media only screen and (max-width: 1199px){
    .col-md-9,.col-md-3{
        display: flex;
        flex-direction: column !important;
        width: 100%;
    }
    .container .row .row{
        margin-top: 5px;
    }
}

@media only screen and (max-width: 991px){
    .navbar-collapse.header-navigation {
        display: flex;
        justify-content: center;
        text-align: center;
    }
    .navbar-brand{
        width: 100%;
        text-align: center;
    }
    .navbar .col-auto {
        width: 100%;
        justify-content: center;
    }
    .dropdown-item{
        text-align: center;
    }
}

@media only screen and (max-width: 767px){
    .footer-main .row .col-sm-12{
        justify-content: center !important;
    }
    .footer-bottom{
        justify-content: center !important;
        text-align: center;
    }
}

@media only screen and (min-width: 1200px){
    .product-categories-area .col-md-6{
        width: 100%;
    }
}

</style><?php }
}
