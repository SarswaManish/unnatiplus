// Jquery with no conflict
jQuery(document).ready(function($) {

    //##########################################
	// HOME SLIDER
	//##########################################
	
    $('.home-slider').flexslider({
    	animation: "fade",
    	controlNav: true,
    	keyboardNav: true
    });
    

	//##########################################
	// Toggle box
	//##########################################
	
	$('.toggle-trigger').click(function() {
		$(this).next().toggle('slow');
		$(this).toggleClass("active");
		return false;
	}).next().hide();
	
	//##########################################
	// Tabs
	//##########################################

    //$(".tabs").tabs("div.panes > div", {effect: 'fade'});
	
	//##########################################
	// Masonry
	//##########################################
	
	
	function masonryStart(){
	
		// Destroy by default
		
		


		// Featured posts
		
		var $container = $('.featured');
		
		$container.imagesLoaded(function(){
			$container.masonry({
				itemSelector: 'figure',
				isAnimated: true
			});
		});
		
		// Text posts
		
		var $container2 = $('.text-posts');
		
		$container2.imagesLoaded(function(){
			$container2.masonry({
				itemSelector: 'li'
			});
		});
		
		// Home gallery
		
		var $container3 = $('.home-gallery');
		
		$container3.imagesLoaded(function(){
			$container3.masonry({
				itemSelector: 'li'
			});
		});
	
	}
		
	
	//##########################################
	// Scroll to top
	//##########################################
	
        
    $('#to-top').click(function(){
		$('html, body').animate({ scrollTop: 0 }, 300);
	});
	
	//##########################################
	// Resize event
	//##########################################
	
	/*
	$(window).resize(function() {
		tooltipPosition();
		masonryStart();
	}).trigger("resize");
	*/

	
	//##########################################
	// Mobile nav
	//##########################################

	var mobnavContainer = $("#mobile-nav");
	var mobnavTrigger = $("#nav-open");
	
	mobnavTrigger.click(function(){
		mobnavContainer.slideToggle();
	});

    
//close			
});