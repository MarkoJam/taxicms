(function($) {
  "use strict";

  $('.itemheight').matchHeight({
           byRow: true,
  		property: 'height',
  		target: null,
  		remove: false
  		});

  var swiper = new Swiper(".myimagethumb", {
    spaceBetween: 10,
    slidesPerView: 2,
    freeMode: true,
    watchSlidesProgress: true,
    breakpoints: {
          991: {
            slidesPerView: 3,
          },
        }
  });
  var swiper2 = new Swiper(".myimage", {
    spaceBetween: 10,
    thumbs: {
      swiper: swiper,
    }
  });

  lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true,
      'alwaysShowNavOnTouchDevices': true
  })


  // Scroll Top Hide Show
  var varWindow = $(window);
  varWindow.on('scroll', function(){
    if ($(this).scrollTop() > 250) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });
  /*------ Sticky menu start ------*/
  var $window = $(window);
  $window.on('scroll', function () {
    var scroll = $window.scrollTop();
    if (scroll < 300) {
      $(".sticky").removeClass("is-sticky");
      $(".main-content").removeClass("is-main");
    } else {
      $(".sticky").addClass("is-sticky");
      $(".main-content").addClass("is-main");
    }
  });
  /*------ Sticky menu end ------*/

  //Scroll To Top Animate
  $('.scroll-to-top').on('click', function(){
    $('html, body').animate({scrollTop : 0},800);
    return false;
  });
  $(document).on('click', function (e) {
    if ($(e.target).closest(".soc.open").length === 0) {
        $(".soc").removeClass('open');
    }
    $('.soc.cont').click(function() {
      $('.soc.inews').removeClass('open');
    });
    $('.soc.inews').click(function() {
      $('.soc.cont').removeClass('open');
    });
});
  $('.soc').click(function() {
    $(this).toggleClass('open');
  });

  var x=15;
  var size_gallery = $(".content-gallery .galerija-wrap").size();
      $('.content-gallery .galerija-wrap').slice(0, x).show();
      if (size_gallery > x){
        $('.loadmore').show();
      }
      $('#loadMore').on('click', function (e) {
          e.preventDefault();
          x = x+15;
          $('.content-gallery .galerija-wrap').slice(0, x).slideDown();
      });

})(window.jQuery);


function update_basket(url) {
    	$.ajax({
    		type: 'GET',
    		url: url,
    		async: false,
    		success: function(data) {
          //console.log("dodato u korpu");
    			$('#cart_content').html(data);
    		//	$(".mini-cart-sub").addClass("open");
			//	window.scrollBy(100, 0);
    			var submit = $('#add_cart span').text('Added!');
    			setTimeout(function() {$(submit).text('Add to Cart') }, 2000);
    		//	setTimeout(function() {$(".mini-cart-sub").removeClass("open") }, 2000);
    		}
    	})
    }

$(document).ready(function() {

  function update_collapse() {
     if ($(window).width() >= 768) {
       $('.accordion-button').attr('data-bs-toggle', '');
     }
     else {
         $('.accordion-button').attr('data-bs-toggle', 'collapse');
       }
     }

    $(window).resize(function() {
         update_collapse();
     });
     $( window ).on( "load", function() {
       update_collapse();
   });

    	window.addEventListener("resize", function() {

    	//	"use strict"; window.location.reload();

    //	document.addEventListener("DOMContentLoaded", function(){
    //    console.log('Dom loaded');

    		// make it as accordion for smaller screens
    		if (window.innerWidth > 992) {

    			document.querySelectorAll('.navbar .nav-item.dropdown').forEach(function(everyitem){

    				everyitem.addEventListener('mouseover', function(e){

    					let el_link = this.querySelector('a[data-bs-toggle]');

    					if(el_link != null){
    						let nextEl = el_link.nextElementSibling;
    						el_link.classList.add('show');
    				 		nextEl.classList.add('show');
    					}

    				});
    				everyitem.addEventListener('mouseleave', function(e){
    				 	let el_link = this.querySelector('a[data-bs-toggle]');

    					if(el_link != null){
    						let nextEl = el_link.nextElementSibling;
    						el_link.classList.remove('show');
    				 		nextEl.classList.remove('show');
    					}

    				})
    			});
    		}
        });
    		// end if innerWidth
    //	});
    	// DOMContentLoaded  end
});

//$(document).on('click', function () {
//    $('#navbarSupportedContent').collapse('hide');
//});
