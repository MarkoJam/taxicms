<style>

body{
    overflow-x: hidden;
}

img{
    border-radius: 5px;
}

p{
    margin-bottom:auto;
}


.wrapper-edit{
    display: flex;
    min-height: 100vh;
    flex-direction: column;
    background-image: url(https://www.taxicms.com/images/background-section.png);
    
}

/* HEADER: ======================================================================== */
.header-middle{
    background: #d7d7d75c;
    background-image: url(https://www.taxicms.com/images/kocka.png),url(https://www.taxicms.com/images/kocka-right.png);
    background-repeat: no-repeat, no-repeat;
    background-position: left, right;
} 

.navbar-default-edit{
    /* old */
    /* background-image: linear-gradient(#d0deed, #73a9d1);
    box-shadow: 2px 1px 6px 2px #4a3f3f;
    border-radius: 10px; */
    background-image: linear-gradient(#f7f7f7, #cbcbcb) !important;
    /* background: #929394; old */
    box-shadow: rgb(85, 85, 85) 0px 1px 4px;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-color: #e7e7e7;
}

/* Navigation: */
.dropdown-menu{
    width:auto;
    background-image: linear-gradient(#f7f7f72b, #cbcbcb42);
    /* background: rgba(226, 237, 243, 0.78); old */
    border-radius: 7px;
    left:0;
}
.submenu-nav:before, .dropdown-menu:before{
    border-bottom: none;
}
.header-navigation .main-nav > li > a:hover {
    color: #ff9c04;
}
.submenu-nav-link:hover, .dropdown-item:hover {
    color: #ff9c04;
    background-color: transparent;
}



/* MIDDLE: ========================================================================= */

.main-content-edit{
    flex:1;
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
#content{ padding:10px; }
/* ------------------------------------------ */
.carousel-caption-edit p{
    /* font-size: 1.5vw; */
    font-size: 1.1rem;
}
.carousel-caption-edit h5 a{
    color: #fff;
}

.carousel-button-edit{
    margin-bottom: 90px;
    border-radius: 5px;
    background: #ff9c04;
}
/* ------------------------------------------ */
/* Packages: */
.row-edit .col-md-3{
    width: 23%;
    margin: 1%;
    background: #ff8f00b0;
    border-radius: 6px;
    box-shadow: 1px 1px 6px 0px #888888;
    padding: 10px;
}

/* .container{
    margin-bottom: 10px;
} */

.wrapper-section{
    background-image: url(https://www.taxicms.com/images/light_noise_diagonal.png);
    padding: 10px;
}

/* Modules: */
.col-md-6-modules-edit{
	margin-bottom: 10px;
}

.add-navlinks-default-row{
    background-color: #7a7a7a17;
    text-shadow: 0px 1px 1px #686767;
}

/* BOTTOM: ======================================================================= */

.footer-area-edit{
    /* background-image: linear-gradient(#307cb5,#31607e); old */
    background-image: linear-gradient(#42586845,#2e5987a3);
    box-shadow: 4px 2px 9px 2px #000000;
    color: #282828;
    font-size: 19px;
}
.footer-area-edit a{
    color: #282828;
}
.footer-area-edit a:hover{
    color: #d58100;
}

/* ================================================================================ */
/* ================================================================================ */
/* MEDIA QUERY: */

@media only screen and (min-width: 1200px){
    .product-categories-area .col-md-6{
        width: 100%;
    }
}

@media only screen and (max-width: 1400px){
    .carousel-caption-edit p{
        margin-bottom: 10px;
    }
}

@media only screen and (max-width: 1199px){
    .col-md-9,.col-md-3{
        /* display: flex;
        flex-direction: column !important;
        width: 100%; */
    }
    .container .row .row{
        margin-top: 5px;
    }

    .logo-main-edit{
        width: auto !important;
    }

  
}

@media only screen and (max-width: 991px){
    /* For menu: */
    /* .navbar-collapse.header-navigation {
        display: flex;
        justify-content: center;
        text-align: center;
    } */

    /* .navbar-brand{
        width: 100%;
        text-align: center;
    } */
    .navbar .col-auto {
        width: 100%;
        justify-content: center;
    }
    
    /* Drop down menu: */
    /* 
     .navbar-nav{
        text-align: center;
    } 
    .dropdown-item{
        text-align: center;
    } 
    */

    .logo-main-edit{
        width: auto !important;
    }
    .navbar-toggler{
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

    .navbar-brand{
        width: auto;
    }

    .orange img{
        margin: 0 auto;
    }
    .orange .col-md-3{
        text-align: center;
        padding-bottom: 15px;
    }

    .row-edit .col-md-3{
        width: 98%;
    }
    /* News area: */
    .news-area-edit .col-sm-6{
        width: auto;
    }
    /* Benefits: */
    .white_orange{
        margin-bottom: 10px;
    }
}

@media only screen and (max-width: 600px){
    .carousel-caption-edit h5 a, .carousel-caption-edit p{
        color: #404040;
    }
    .carousel-button{
        width:50%;
    }
}


</style>