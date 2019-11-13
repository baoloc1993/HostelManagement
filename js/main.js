/* ======================================
-----------------------------------------
	Template Name: Photographer
	Description: Photographer HTML Template
	Author: colorlib
	Author URI: https://www.colorlib.com/
	Version: 1.0
	Created: colorlib
 ---------------------------------------
 =======================================*/


'use strict';

$(window).on('load', function() {
	/*------------------
		Preloder
	--------------------*/
	$(".loader").fadeOut();
	$("#preloder").delay(400).fadeOut("slow");

	/*---------------------
		Instagram slider
	----------------------*/
	$('.instagram-slider').owlCarousel({
		nav: false,
		dots: false,
		loop: true,
		autoplay: true,
		responsive : {
			0 : {
				items: 3,
			},
			480 : {
				items: 4,
				
			},
			768 : {
				items: 5,
			},
			991 : {
				items: 6,
			},
			1200 : {
				items: 7,
			}
		}
	});

	/*---------------
		Masonry
	----------------*/
	var masonryLayout = function () {
		$('.portfolio-grid').masonry({
			itemSelector: '.grid-item',
			columnWidth: '.grid-sizer',
			percentPosition: true
		});
	}

	/*---------------
		Mixitup
	----------------*/
	masonryLayout();
	if($('.portfolio-gallery').length > 0 ) {
		var containerEl = document.querySelector('.portfolio-gallery');
		var mixer = mixitup(containerEl, {
			callbacks: {
				onMixEnd: function() {
					masonryLayout();
				}
			}
		});
	}

    $.ajax({
        url: "api/user_gallery.php?action=get",
        async: false,
        success: function(result){
            var images = JSON.parse(result);
            var selection1 ="<div class=\"hero-section\" >\n";
            var selection2 ="<div class=\"hero-section\" >\n";
            var maxRow = 5;
            if (window.innerWidth < 600){
            	maxRow = 1;

                var set = [];
                var i = 0;

                for ( ; i<images.length/2; i++) {
                    var image = images[i];
                    if (set.indexOf(image.room) >= 0) continue;
                    set.push(image.room);
					selection1 += "<div class=\"hero-slider owl-carousel\">";
                    selection1 += "<div class=\"hero-item portfolio-item set-bg\" data-setbg=\"" + image.img + "\">";
                    selection1 += "            <a class=\"hero-link\">\n" +
                        "                <h2>" + image.room + "<br/>" + image.name + "</h2>\n" +
                        "            </a></div></div>"
                }
                selection1 += "</div>";
                for ( ; i<images.length; i++) {
                    var image = images[i];
                    if (set.indexOf(image.room) >= 0) continue;
                    set.push(image.room);
                    selection2 += "<div class=\"hero-slider owl-carousel\">";
                    selection2 += "<div class=\"hero-item portfolio-item set-bg\" data-setbg=\"" + image.img + "\">";
                    selection2 += "            <a class=\"hero-link\">\n" +
                        "                <h2>" + image.room + "<br/>" + image.name + "</h2>\n" +
                        "            </a></div></div>"
                }
                selection2 += "</div>";
                $("#gallery").html(selection1);
                $("#gallery2").html(selection2);
			}else if (window.innerWidth > 600){
                maxRow = 7;
                var set = [];

                for (var i = 0 ; i<images.length; i++) {
                    var image = images[i];
                    if (set.indexOf(image.room) >= 0) continue;
                    set.push(image.room);
                    if (i % maxRow === 0){
                        selection1+= "<div class=\"hero-slider owl-carousel\">";
                    }
                    selection1 += "<div class=\"hero-item portfolio-item set-bg\" data-setbg=\"" + image.img + "\">";
                    selection1 += "            <a class=\"hero-link\">\n" +
                        "                <h2>" + image.room + "<br/>" + image.name + "</h2>\n" +
                        "            </a></div>"
                    if (i % maxRow === maxRow-1 || i === images.length-1){
                        selection1 += "</div>";
                    }
                }
                selection1 += "</div>";
                $("#gallery_full").html(selection1);

            }




            $('.hero-slider').owlCarousel({
                nav: false,
                dots: false,
                loop: false,
                autoplay: false,
                smartSpeed: 1000,
                responsive : {
                    0 : {
                        items: 1,
                    },
                    480 : {
                        items: 2,

                    },
                    768 : {
                        items: 3,
                    },
                    991 : {
                        items: 4,
                    },
                    1200 : {
                        items: 5,
                    },
                    1400 : {
                        items: 7,
                    }
                }
            });
            $('.set-bg').each(function() {
                var bg = $(this).data('setbg');
                $(this).css('background-image', 'url(' + bg + ')');
            });
        },
        method: "get"
    });
});

