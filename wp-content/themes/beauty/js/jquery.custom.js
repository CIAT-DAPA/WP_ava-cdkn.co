//emulate jquery live to preserve jQuery.live() call
if( typeof jQuery.fn.live == 'undefined' ) {
    jQuery.fn.live = function( types, data, fn ) {
        jQuery( this.context ).on( types, this.selector, data, fn );
        return this;
    };
}

jQuery(document).ready(function($){

	$('body').removeClass('no_js').addClass('yes_js'); 
    
    $('#nav li, ul.sub-menu, ul.children').each(function(){
        n = $('ul.sub-menu:not(ul.sub-menu li > ul.sub-menu), ul.children:not(ul.children li > ul.children)', this).length;
        
        if(n) $(this).addClass('parent');
    });
    
    $('#nav ul.sub-menu li, #nav ul.children li').hover(
    
        function()
        {
            $(this).stop(true, true).animate({paddingLeft:10 }, 200);
        },
        
        function()
        {
            $(this).animate({ paddingLeft:0 }, 200);
        }
    
    );
        
    $('#nav ul > li').hover(
        function()
        {
            $('ul.sub-menu:not(ul.sub-menu li > ul.sub-menu), ul.children:not(ul.children li > ul.children)', this).stop(true, true).fadeIn(300);    
        },
    
        function()
        {
            $('ul.sub-menu:not(ul.sub-menu li > ul.sub-menu), ul.children:not(ul.children li > ul.children)', this).fadeOut(300);    
        }
    );   
	
	function add_indicator(e) {                                                                       
		var element_width = $(e).outerWidth();
		var offset_right = $('#wrapper').width() - ( $(e).offset().left + element_width );
		      
		class_indicator = '';      
		if ( offset_right < element_width )
			class_indicator = '-reverse';
		
		$(e).children('a').append('<span class="sf-sub-indicator' + class_indicator + '"> &raquo;</span>');	
	}           
    
    $('#nav ul > li').each(function(){
        if( $('ul', this).length > 0 )
            $(this).children('a').append('<span class="sf-sub-indicator"> &raquo;</span>');	
    }); 
    
    $('#nav ul.sub-menu li, #nav ul.children li').hover(
        function()
        {
            var options;
            
            winWidth = $(document).width();
            
            subMenuWidth = $(this).parent().outerWidth();
            space = $(this).offset().left + subMenuWidth * 2;
            
//             if(space < winWidth) options = {left:subMenuWidth-26};
//             else options = {left:subMenuWidth*-1};
            
            options = {left:subMenuWidth-26};
            
            $('ul.sub-menu, ul.children', this).hide().css(options).stop(true, true).fadeIn(300);
        },
    
        function()
        {
            $('ul.sub-menu, ul.children', this).fadeOut(300);
        }
    ); 

	function yiw_lightbox()
	{   
	    $('a.thumb').hover(
	                            
	        function()
	        {
	            $('<a class="zoom">zoom</a>').appendTo(this).css({
					dispay:'block', 
					opacity:0, 
					height:$(this).children('img').height(), 
					width:$(this).children('img').width(),
					'top':$(this).css('padding-top'),
					'left':$(this).css('padding-left'),
					padding:0}).animate({opacity:0.4}, 500);
	        },
	        
	        function()
	        {           
	            $('.zoom').fadeOut(500, function(){$(this).remove()});
	        }
	    );
	    
		jQuery("a[rel^='prettyPhoto']").prettyPhoto({
	        slideshow:5000, 
	        autoplay_slideshow:false,
	        show_title:false
	    });
	}
	
	yiw_lightbox();

    $('a.socials, a.socials-small').tipsy({fade:true, gravity:'s'});
    
    $('.toggle-content:not(.opened), .content-tab:not(.opened)').hide();
    $('.toggle-title').click(function(){
        $(this).next().slideToggle(300);
        $(this).children('span.open-toggle').toggleClass('closed');
        $(this).attr('title', ($(this).attr('title') == 'Close') ? 'Open' : 'Close');
        return false;
    });     
    $('.tab-index a').click(function(){           
        $(this).parent().next().slideToggle(300, 'easeOutExpo');
        $(this).toggleClass('opened');
        $(this).attr('title', ($(this).attr('title') == 'Close') ? 'Open' : 'Close');
        return false;
    });     
    
    $('.tabs-container').tabs();                                       
    $('.tabs-container').tabs( "option", "fx", { opacity: 'toggle' } );
    
    $('#slideshow images img').show();
});          