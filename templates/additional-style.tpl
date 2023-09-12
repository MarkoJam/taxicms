<style>

/* PARTS: */

/* .wrapper{
} */
.main-content{
    background-image: url(http://localhost/taxicms/images/background-section.png);
}

.footer-area{
    background-image: linear-gradient(#31607e, #307cb5);
    box-shadow: 4px 2px 9px 2px #000000;
}
/* -------------------------------------------------------------------------------- */
.navbar-default-edit{
    background: aliceblue;
    border-radius: 10px;
}
/* .header-wrapper-edit{
    height:auto;
} */
.dropdown-menu{
    width:auto;
    background: rgba(226, 237, 243, 0.78);
    border-radius: 7px;
    left:0;
}
.submenu-nav:before, .dropdown-menu:before{
    border-bottom: none;
}
/* Social icons: */
.social-icons a div, .social-icons div{
    background: #3549ad;
    border-radius: 5px;
}
.social-icons a div:hover, .social-icons div:hover{
    background: #4b61d3;
}
/* -------------------------------------------------------------------------------- */
/* Section: */
.news-area.page-top .container .row div{
    margin-bottom: 10px;
}

#content .container .row{
    border-radius: 5px !important;
}
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

</style>