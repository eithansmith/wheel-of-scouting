(function( $ ) {
	
	"use strict";
	
    $.fn.pcm_table_excel_export = function(options) {
    	// initialize defaults - which can be extended by options
    	var defaults = {};
    	var options = $.extend(defaults, options);
    	
    	return this.each(function() {
	        var table = $(this);
	        
	        table.options = options;
	        table.id = table.attr('id');
	        
	        // when the export excel button is clicked this stores a serialized json string
	    	// of the html table, that string is later use to build the excel download
	    	$('form#'+table.id+'_excel_export').submit(function(e) {
	    		
	    		if (typeof e.originalEvent !== 'undefined') {
		    		e.preventDefault();
		    		
		    		var json = tableToJSON(table.id);
		    		var json_text = JSON.stringify(json, null, 2);
		    		
		    		//console.log(json);
		    		//console.log(json_text);
		    		
		    		$('form#'+table.id+'_excel_export > input.excel_export_json').val(json_text);
		    		
		    		//alert(json_text);
		    		$('form#'+table.id+'_excel_export').trigger('submit');
	    		}
	    		
	    	});
	        
	    	var tableToJSON = function (id) {
	    		var columns = $('table#'+id+' > thead:first > tr > th').map(function() {
	    			  // This assumes that your headings are suitable to be used as
	    			  //  JavaScript object keys. If the headings contain characters 
	    			  //  that would be invalid, such as spaces or dashes, you should
	    			  //  use a regex here to strip those characters out.
	    			  return $.trim($(this).text());
	    		});
	    		
	    		var json = $('table#'+id+' > tbody > tr:not(.filtered)').map(function(i) {
	    			  var row = {};
	    			 
	    			  // Find all of the table cells on this row.
	    			  $(this).find('td').each(function(i) {
	    			    // Determine the cell's column name by comparing its index
	    			    //  within the row with the columns list we built previously.
	    			    var rowName = columns[i];
	    			 
	    			    // Add a new property to the row object, using this cell's
	    			    //  column name as the key and the cell's text as the value.
	    			    if ($(this).find('input:text').length) 
	    			    { 
	    			    	row[rowName] = $.trim($(this).find('input:text').val());
	    			    }
	    			    else if ($(this).find('div.switch').length) 
	    			    { 
	    			    	if ($(this).find('input:checkbox').attr('checked'))
	    			    		row[rowName] = $.trim($(this).find('div.switch').attr('data-on-label'));
	    			    	else
	    			    		row[rowName] = $.trim($(this).find('div.switch').attr('data-off-label'));
	    			    }
	    			    else
	    			    {
	    			    	row[rowName] = $.trim($(this).text());
	    			    }
	    			  });
	    			 
	    			  // Finally, return the row's object representation, to be included
	    			  //  in the array that $.map() ultimately returns.
	    			  return row;
	    			 
	    			// Don't forget .get() to convert the jQuery set to a regular array.
	    		}).get();
	    		
	    		return json;
	    	};
	    	
    	});             
    };
    
})(jQuery);