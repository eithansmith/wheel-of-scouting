(function( $ ) {
	$.fn.pcm_table_filter = function(options) {
		// initialize defaults - which can be extended by options
		var defaults = {};
		var options = $.extend(defaults, options);
		
		return this.each(function() {
            // get list of options, if any functions are to be "overridden"
			// overwrite these local functions with those passed in via options
			var o = options;
            if (o.hasOwnProperty('hideLoader'))
            	hideLoader = o.hideLoader;
            if (o.hasOwnProperty('showLoader'))
            	showLoader = o.showLoader;
            if (o.hasOwnProperty('createFilters'))
            	createFilters = o.createFilters;
            if (o.hasOwnProperty('recolorRows'))
            	recolorRows = o.recolorRows;
            if (o.hasOwnProperty('clearFilters'))
            	clearFilters = o.clearFilters;
            if (o.hasOwnProperty('clearHiddenRows'))
            	clearHiddenRows = o.clearHiddenRows;
            if (o.hasOwnProperty('hideRowsByFilters'))
            	hideRowsByFilters = o.hideRowsByFilters;
            if (o.hasOwnProperty('countRecords'))
            	countRecords = o.countRecords;
            if (o.hasOwnProperty('sumRecords'))
            	sumRecords = o.sumRecords;
            
            
            // make jQuery variable out of table 
    		var table = $(this);
    		var id = table.attr('id');
    		
    		// upon DOM load, hide loader image
    		// color rows, create filters, count & sum records, and
    		// clear any filters (this also sets the last item on the max dropdowns -ex. Gauge, Width)
    		hideLoader(id);
    		recolorRows(id);
    		createFilters(id);
    		countRecords(id);
    		sumRecords(id);
    		clearFilters(id);
    		
    		/// --- bind event functions below ---
    		
    		// tablesorter state change (sort)
    		$(table).bind('sortStart', function() { 
    			showLoader(id);
    	    }).bind('sortEnd', function() { 
    	    	//alert('you triggered a sort filter');
    	    	recolorRows(id);
    			hideLoader(id);
    	    });
    		
    		// dropdown select filter state change
    		var selects = $('table#'+id+' > thead > tr#filter_row > th > select');
    		selects.bind('change', function() {
    			//alert('you triggered a select filter');
    			showLoader(id);
    			clearHiddenRows(id);
    			hideRowsByFilters(id);
    			countRecords(id);
    			sumRecords(id);
    			recolorRows(id);
    			hideLoader(id);
    		});
    		
    		// input filter state change
    		var wto;
    		var inputs = $('table#'+id+' > thead > tr#filter_row > th > input.flt_s');
    		inputs.bind('keyup', function() {
    			clearTimeout(wto);
    			wto = setTimeout(function() {
    				//alert('you triggerd a input filter');
    				showLoader(id);
    				clearHiddenRows(id);
    				hideRowsByFilters(id);
    				countRecords(id);
    				sumRecords(id);
    				recolorRows(id);
    				hideLoader(id);
    			  }, 500);
    		});
    		
    		// clean filters href click
    		var clear_filters_button = $('a#'+id+'_clear_filters');
    		clear_filters_button.bind('click', function() {
    			//alert('you triggered a clear filter');
    			showLoader(id);
    			clearFilters(id);
    			clearHiddenRows(id);
    			countRecords(id);
    			sumRecords(id);
    			recolorRows(id);
    			hideLoader(id);
    		});
              
		});
		
		
	};

})(jQuery);

function hideLoader(id)
{
	$('div#'+id+'_loader').fadeOut('slow');
}

function showLoader(id)
{
	$('div#'+id+'_loader').fadeIn('slow');
}

function createFilters(id)
{
	// add 2nd row to table header (id of filter_row) - this will store the drop drowns and input boxes used for filtering
	$('table#'+id+' > thead:first tr').attr('id', 'header_row');
	$('table#'+id+' > thead:last').append('<tr id="filter_row"><tr/>');
	
	// build the input boxes/drop downs based on the filter-type html attribute	
	var header_row_th = $('table#'+id+' > thead > tr#header_row > th');
	header_row_th.each(function(i) {
		var this_header_row = $(this);
		
		// get the filter-type - if it doesn't exist then set it to false
		if (this_header_row.attr('filter-type'))
			var filter_type = this_header_row.attr('filter-type');
		else
			var filter_type = false;
		
		// get the TH visibility
		if(this_header_row.css('display') == 'none')
			var visible = false;
		else
			var visible = true;
		
		// build the html based on filter-type
		var filter_row = $('table#'+id+' > thead > tr#filter_row');
		if (filter_type == 'rang' && visible == true)
		{
			var items = [];
			var options_min = '';
			var options_max = '';
			var column = i+1;
			
			// for drop down lists - get a list of unique items
			var td_by_col = $('table#'+id+' > tbody > tr > td:nth-child('+column+')');
			var td_by_col_length = td_by_col.length;
			var itr;
			for (itr = 0; itr < td_by_col_length; ++itr) {
			//td_by_col.each(function(){
				//add item to array
				//var html = $(this).text();
				var html = $(td_by_col[itr]).text();
				items.push($.trim(html));       
			}
			
			//alert(items);
			items = arrayUnique(items);
			items.sort(function(a,b){ return a - b; });			
			//alert(items);
			
			$.each(items, function(j) {
			    options += '<option value="' + items[j] + '">' + items[j] + '</option>';
			});
			
			filter_text = '<th><select id="filter_select_min_'+i+'" class="flt_min_max flt_min">'+options+'</select>';
			filter_text += '<br>';
			filter_text += '<select id="filter_select_max_'+i+'" class="flt_min_max flt_max">'+options+'</select></th>';
			filter_row.append(filter_text);

			var filter_select_max = $('table#'+id+' > thead > tr#filter_row > th > select#filter_select_max_'+i);
			filter_select_max.append(filter_text);
		}
		else if (filter_type == 'ddl' && visible == true)
		{
			var items = [];
			var options = '';
			var column = i+1;
			
			// for drop down lists - get a list of unique items
			var td_by_col = $('table#'+id+' > tbody > tr > td:nth-child('+column+')');
			var td_by_col_length = td_by_col.length;
			var itr;
			for (itr = 0; itr < td_by_col_length; ++itr) {
			//td_by_col.each(function(){
				//add item to array
				//var html = $(this).text();
				var html = $(td_by_col[itr]).text();
				items.push($.trim(html));       
			}
			
			//alert(items);
			items = arrayUnique(items);
			items.sort();			
			//alert(items);
			filter_text = '<th><select id="filter_select_'+i+'" class="flt"><option value="*-SHOW-ALL-*">*ALL</option></select></th>';
			filter_row.append(filter_text);
			
			$.each(items, function(j) {
			    options += '<option value="' + items[j] + '">' + items[j] + '</option>';
			});

			var filter_select = $('table#'+id+' > thead > tr#filter_row > th > select#filter_select_'+i)
			filter_select.append(options);
			
		}
		else if (filter_type == 'text' && visible == true)
		{
			filter_row.append('<th><input type="text" class="flt_s" placeholder="*ALL" title="Supports &gt;, &gt;=, &lt;, &lt;=, =, and &lt;&gt; operators. If not used, checks if it contains the value."></th>');
		}
		else if (visible == true)
		{
			filter_row.append('<th>&nbsp;</th>');
		}
		
		$('table#'+id+' > tfoot:first tr').attr('id', 'total_row');
	});
}

function recolorRows(id)
{
	$('table#'+id+' > tbody > tr:not(.filtered):odd').addClass('odd').removeClass('even');
	$('table#'+id+' > tbody > tr:not(.filtered):even').addClass('even').removeClass('odd');
}

function clearFilters(id)
{
	$('table#'+id+' > thead > tr#filter_row > th > select > option:selected').removeAttr('selected');
	
	var select_flt = $('table#'+id+' > thead > tr#filter_row > th > select.flt');
	select_flt.each(function() {
		$(this).children('option:first').attr('selected', true);
	});
	
	var select_flt_min = $('table#'+id+' > thead > tr#filter_row > th > select.flt_min');
	select_flt_min.each(function() {
		$(this).children('option:first').attr('selected', true);
	});
	
	var select_flt_max = $('table#'+id+' > thead > tr#filter_row > th > select.flt_max');
	select_flt_max.each(function() {
		$(this).children('option:last').attr('selected', true);
	});
}

function clearHiddenRows(id)
{
	$('table#'+id+' > tbody > tr.filtered').removeClass('filtered');
}

function hideRowsByFilters(id)
{	
	// work from left to right, filtering the results	
	var header_row_th = $('table#'+id+' > thead > tr#header_row > th');
	header_row_th.each(function(i) {
		var this_header_row = $(this);
		
		// get the filter-type - if it doesn't exist then set it to false
		if (this_header_row.attr('filter-type'))
			var filter_type = this_header_row.attr('filter-type');
		else
			var filter_type = false;
		
		//alert(filter_type);
		
		// get the TH visibility
		if(this_header_row.css('display') == 'none')
			var visible = false;
		else
			var visible = true;
		
		// begin filter
		var column = i+1;
		var tds_not_filtered = $('table#'+id+' > tbody > tr > td:nth-child('+column+'):not(.filtered)');
		if (filter_type == 'rang' && visible == true)
		{
			var filter_min_value = parseFloat($('table#'+id+' > thead > tr#filter_row > th:nth-child('+column+') select.flt_min').val());
			var filter_max_value = parseFloat($('table#'+id+' > thead > tr#filter_row > th:nth-child('+column+') select.flt_max').val());
			
			// is the min actually larger than the max? then flip the values for the user
			if (filter_min_value > filter_max_value)
			{
				var temp = filter_min_value;
				filter_min_value = filter_max_value;
				filter_max_value = temp;
			}
			
			// for each value in the column, check it against the filter min and max
			// if the value is within the range skip it (keeping it visible), otherwise hide it
			tds_not_filtered.each(function(){
				var this_td_not_filtered = $(this);
				var html = $.trim(this_td_not_filtered.text());
				var value = parseFloat(html);
				//alert(filter_min_value+' '+value+' '+filter_max_value);
				if (value < filter_min_value || value > filter_max_value)
				{
					//alert('adding filter class to this row');
					this_td_not_filtered.parent('tr').addClass('filtered');
				}
			});
			
		}
		else if (filter_type == 'ddl' && visible == true)
		{
			var filter_value = $('table#'+id+' > thead > tr#filter_row > th:nth-child('+column+') select.flt').val();
			
			//alert(filter_value+' '+column);
			
			// as long as ALL is not the value
			if (filter_value != '*-SHOW-ALL-*')
			{
				// for each value in the column, check it against the filter_value
				// if they match skip it (keeping it visible), otherwise hide it
				tds_not_filtered.each(function(){
					var this_td_not_filtered = $(this);
					var html = $.trim(this_td_not_filtered.text());
					if (html != filter_value)
					{
						this_td_not_filtered.parent('tr').addClass('filtered');
					}
				});
			}
		}
		else if (filter_type == 'text' && visible == true)
		{
			var filter_value = $('table#'+id+' > thead > tr#filter_row > th:nth-child('+column+') input.flt_s').val();
			if (filter_value)
			{
				tds_not_filtered.each(function(){
					var this_td_not_filtered = $(this);
					var html = $.trim(this_td_not_filtered.text());
					var html_no_commas = html.replace(/,/g,'');
					var html_uppercase = html.toUpperCase();
					filter_value = $.trim(filter_value);
					var filter_value_no_commas = filter_value.replace(/,/g,'');
					var filter_value_uppercase = filter_value.toUpperCase();
					var first_char = filter_value.charAt(0);
					var second_char = filter_value.charAt(1);
					
					//alert(first_char);
					
					if (first_char == '=') // simple equality ==
					{
						var tmp_filter_value = $.trim(filter_value.substr(1));
						var filter_value_no_commas = tmp_filter_value.replace(/,/g,'');

						//alert(parseFloat(html_no_commas)+' == '+parseFloat(filter_value_no_commas));
						
						if (parseFloat(html_no_commas) != parseFloat(filter_value_no_commas))
						{
							this_td_not_filtered.parent('tr').addClass('filtered');
						}
					}
					else if (first_char == '>' && second_char == '=') // greater than or equal to
					{
						var tmp_filter_value = $.trim(filter_value.substr(2));
						var filter_value_no_commas = tmp_filter_value.replace(/,/g,'');
						
						var html_float = parseFloat(html_no_commas);
						var filter_float = parseFloat(filter_value_no_commas);
						
						//alert(html_float+' >= '+filter_float);
						
						if (!(html_float >= filter_float)) 
						{
							this_td_not_filtered.parent('tr').addClass('filtered');
						}
					}
					else if (first_char == '>') // greater than
					{
						var tmp_filter_value = $.trim(filter_value.substr(1));
						var filter_value_no_commas = tmp_filter_value.replace(/,/g,'');
						
						var html_float = parseFloat(html_no_commas);
						var filter_float = parseFloat(filter_value_no_commas);
						
						//alert(html_float+' >= '+filter_float);
						
						if (!(html_float > filter_float))
						{
							this_td_not_filtered.parent('tr').addClass('filtered');
						}
					}
					else if (first_char == '<' && second_char == '=') // less than or equal to
					{
						var tmp_filter_value = $.trim(filter_value.substr(2));
						var filter_value_no_commas = tmp_filter_value.replace(/,/g,'');
						
						var html_float = parseFloat(html_no_commas);
						var filter_float = parseFloat(filter_value_no_commas);
						
						//alert(html_float+' <= '+filter_float);
						
						if (!(html_float <= filter_float)) 
						{
							this_td_not_filtered.parent('tr').addClass('filtered');
						}
					}
					else if (first_char == '<' && second_char == '>') // not equal to
					{
						var tmp_filter_value = $.trim(filter_value.substr(2));
						var filter_value_no_commas = tmp_filter_value.replace(/,/g,'');
						
						var html_float = parseFloat(html_no_commas);
						var filter_float = parseFloat(filter_value_no_commas);
						
						//alert(html_float+' != '+filter_float);
						
						if (!(html_float != filter_float)) 
						{
							this_td_not_filtered.parent('tr').addClass('filtered');
						}
					}
					else if (first_char == '<') // less than
					{
						var tmp_filter_value = $.trim(filter_value.substr(1));
						var filter_value_no_commas = tmp_filter_value.replace(/,/g,'');
						
						var html_float = parseFloat(html_no_commas);
						var filter_float = parseFloat(filter_value_no_commas);
						
						//alert(html_float+' < '+filter_float);
						
						if (!(html_float < filter_float))
						{
							this_td_not_filtered.parent('tr').addClass('filtered');
						}
					}
					else if (html_uppercase.indexOf(filter_value_uppercase) == -1) // do a LIKE search (no comparrison operator)
					{
						//alert(parseFloat(html_no_commas)+' LIKE '+parseFloat(filter_value_no_commas));
						
						this_td_not_filtered.parent('tr').addClass('filtered');
					}
				});
			}
		}
		
	});
}

function countRecords(id)
{
	var total_records = $('table#'+id+' > tbody > tr').length;
	var filtered_records = $('table#'+id+' > tbody > tr.filtered').length;
	var visibile_records = $('table#'+id+' > tbody > tr:not(.filtered)').length;
	
	total_records = add_commas(total_records);
	filtered_records = add_commas(filtered_records);
	visibile_records = add_commas(visibile_records);
	
	var message = 'Displaying ' + visibile_records + ' of ' + total_records + ' records (' + filtered_records + ' filtered)';
	$('span#'+id+'_filtered_record_count').html(message);
}

function sumRecords(id)
{
	// build the total text based on the field-total html attribute	
	var footer_row_th = $('table#'+id+' > tfoot > tr#total_row > th');
	footer_row_th.each(function(i) {
		var this_footer_row_th = $(this);
		
		// get the field-total - if it doesn't exist then set it to false
		if (this_footer_row_th.attr('field-total'))
		{
			var field_total = this_footer_row_th.attr('field-total');
			if (field_total == 'true')
				field_total = true;
			else
				field_total = false;
		}
		else
			var field_total = false;
		
		// get the TH visibility
		if (this_footer_row_th.css('display') == 'none')
			var visible = false;
		else
			var visible = true;
	
		//alert(i);
		
		// build the html based on filter-type
		if (field_total == true && visible == true)
		{
			var column = i+1;
			var total = 0;
			var rawstring = '';
			var cleanstring = '';
			
			// iterate through each value and sum it
			var td_by_col = $('table#'+id+' > tbody > tr:not(.filtered) > td:nth-child('+column+')');
			var td_by_col_length = td_by_col.length;
			var itr;
			for (itr = 0; itr < td_by_col_length; ++itr) {
				rawstring = $(td_by_col[itr]).text();
				cleanstring = rawstring.replace(/[^\d\.\-\ ]/g, '');
				total += parseFloat(cleanstring);
			}
			
			if (total % 1 != 0)
				total = total.toFixed(2);
			
			total = add_commas(total);
			//alert(total);
			 $('table#'+id+' > tfoot > tr#total_row > th:nth-child('+column+')').html(total);
		}	
	});	
}

function arrayUnique(a) 
{
    var temp = {};
    for (var i = 0; i < a.length; i++)
        temp[a[i]] = true;
    var r = [];
    for (var k in temp)
        r.push(k);
    return r;
}

jQuery.expr[':'].Contains = function(a, i, m) {
	  return jQuery(a).text().toUpperCase()
	      .indexOf(m[3].toUpperCase()) >= 0;
	};