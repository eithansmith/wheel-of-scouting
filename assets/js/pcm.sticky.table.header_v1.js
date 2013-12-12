(function( $ ) {
	
    $.fn.pcm_sticky_table_header = function(options)
    {
    	// initialize defaults - which can be extended by options
    	var defaults = {
    			'default_v_offset' : 40,
    			'default_h_offset' : 20
    	};
    	var options = $.extend(defaults, options);
    	
    	return this.each(function() {
	        var table = $(this);
	        
	        table.options = options;
	        table.pos = table.offset();
	        table.v_offset = table.pos.top - table.options.default_v_offset;
	        table.sticky_mode = false;
	        table.thead_height = $('thead', table).height();
	        
	        $(window).scroll(function(){
	        	//console.log('Scroll Top:'+($(window).scrollTop()-table.thead_height)+' Pos Top:'+table.v_offset);
	            if($(window).scrollTop()-table.thead_height > table.v_offset)
	            {
	                if(!table.sticky_mode){
	                	table.sticky_mode = true;
	                	//console.log('Sticky Mode ON');
	                	createStickyTable(table);
	                }
	                else
	                {
	                	updateHorizontalPosition(table);
	                }
	            }
	            else
	            {
	            	if(table.sticky_mode){
	                	table.sticky_mode = false;
	                	//console.log('Sticky Mode OFF');
	                	destroyStickyTable(table);
	            	}
	            }
	        });
	        
	        $(window).resize(function(){
	        	
	        	if(table.sticky_mode)
	        	{
	        		table.sticky_mode = false;
                	//console.log('Sticky Mode OFF');
                	destroyStickyTable(table);
	        	}
	        	
	        	//console.log('Scroll Top:'+($(window).scrollTop()-table.thead_height)+' Pos Top:'+table.v_offset);
	            if($(window).scrollTop()-table.thead_height > table.v_offset)
	            {
	                if(!table.sticky_mode){
	                	table.sticky_mode = true;
	                	//console.log('Sticky Mode ON');
	                	createStickyTable(table);
	                }
	                else
	                {
	                	updateHorizontalPosition(table);
	                }
	            }
	        });
	        
    	});
        
    };
    
})(jQuery);

function createStickyTable(table)
{
	var sticky_table = $('<div id="sticky_table"></div>')
		.css('z-index', '500')
		.css('position', 'fixed')
		.css('overflow', 'hidden')
		.css('white-space', 'nowrap')
		.css('top', table.options.default_v_offset+'px')
		.css('left',-$(window).scrollLeft()+table.options.default_h_offset);

		
	sticky_table.insertAfter(table);
	
	var header_text = '';
	var header_width = 0;
	var table_th = $('thead tr:first th', table);
	
	table_th.each(function() {
		if ($(this).is(':visible'))
		{
			header_text = $(this).text();
			header_width = $(this).outerWidth();
			header_height = $(this).height();
			//console.log('TH properites: '+header_text+' '+header_width);
			
			// use css rules on class "sticky_header" to make it match the table visually
			// these rules are in the css file pcm_table.css
			var sticky_header = $('<div class="sticky_header"></div>')
				.css('width', header_width+'px')
				.css('height', header_height+'px')
				.css('display', 'inline-table')
				.css('white-space', 'normal')
				.text(header_text);
				
			sticky_table.append(sticky_header);
		}
	});
}

function destroyStickyTable(table)
{
	$('div#sticky_table').remove();
}

function updateHorizontalPosition(table)
{
	$('div#sticky_table').css('left',-$(window).scrollLeft()+table.options.default_h_offset);
}