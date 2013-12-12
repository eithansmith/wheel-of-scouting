$(document).ready(function() {
    
    var oTable = $('.dataTable').dataTable({
    	bJQueryUI: true,
    	"sPaginationType": "full_numbers",
    	"sDom": '<i><"clear"><t>',
    	"iDisplayLength": -1
    });
    
    addDropdownFilters(oTable);
    
    calculatePageTotals();
    
    $(".dataTable thead tr th[class='filter'] select").change(function() {
    	calculatePageTotals();
    	
    	var col = 0;
    	var i = 0;
  
    	// loop through dropdown
    	$(".dataTable thead tr th[class='filter'] select").each(function(i) {

        	// save current selected value
    		var selected = $("option:selected", this).val();
			//alert(selected);
    		
			col = i + 1;
			
    		//build array of column values on page
			var data = new Array();
			$(".dataTable tbody td:nth-child(" + col + ")").each(function () {
				data.push($(this).html());
			});

    		// filter by unique items and sort
    		data = data.getUnique();
    		data.sort();
    		//alert(data);
    		 
    		// remove old entries
			$(this).children('option').remove();

			// get size and insert initial blank entry
			var size = data.length;
			$(this).append($(document.createElement("option")).attr("value","").text("All"));

			// loop through data and add options
			for (i=0; i<size; i++)
		    {
				$(this).append($(document.createElement("option")).attr("value",data[i]).text(data[i]));
		    }

		    // add previous selected value back to dropdown
			$(this).children("option[value='"+selected+"']").attr("selected","selected");
			
    	});

    });
    
    $('#excel input').click(function() {
    	var json = { "excel": [] };
    	$('.dataTable tbody tr').each(function(i) {
    		json.excel.push([]);
    		$(this).find('td').each(function(j) {
    			var data = $(this).html();
    			var format = $(this).attr('excel_format');
    			json.excel[i].push({"data" : data, "format" : format});
    		});
    	});  
    	//console.log(json);
        json = JSON.stringify(json);
    	$("#excel_data").val(json);
    });
    
});

//DataTables Function - adds a drop down for filter th specified
function addDropdownFilters(oTable, filterIDs)
{
	$(".dataTable thead tr[id='filterRow'] th[class='filter']").each(function(i)
	{
		this.innerHTML = fnCreateSelect(oTable.fnGetColumnData(i));
	    $('select', this).change(function() 
		{
	    	oTable.fnFilter( $(this).val(), i );
	    });
	});
}

//DataTables function - calculates totals for selected visible columns and displays results in table footer
function calculatePageTotals()
{
	var i = 0;
   	var totalPositions = new Array();
   	
	$(".dataTable tfoot tr[id='totalRow'] th").each(function(i)
	{
		if ($(this).hasClass('total'))
			totalPositions.push(i);
	});
	
	i = 0;
	var j = 0;
	var row = 0;
	var col = 0;
	var totals = new Array();
	var data = 0;
	
	for (j=0; j < totalPositions.length; j++)
	{
		totals[j] = 0;
	}
	
	$('.dataTable tbody tr').each(function(i) 
	{
		row = i;
		row++;
		for (j=0; j < totalPositions.length; j++)
		{
			col = totalPositions[j];
			col++;
			var data = $('.dataTable tbody tr:nth-child(' + row + ') td:nth-child(' + col + ')').text();
			if (data == null)
				return true;
			data = data.replace(/,/g,"");
			data = parseInt(data);
			totals[j] = totals[j] + data;			
		}
	});
	
	for (j=0; j < totals.length; j++)
	{
		col = totalPositions[j];
		col++;
		var total = totals[j];
		$(".dataTable tfoot tr[id='totalRow'] th:nth-child(" + col + ")").html(total);
	}

}


//DataTables Function - creates and returns html select tag with appropriate option tags from aData
function fnCreateSelect(aData)
{
    var selectTag = '<select class="input-small"><option value="">All</option>';
    var size = aData.length;
    aData.sort();
    
    for (i=0; i<size; i++)
    {
        selectTag += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
    }
    return selectTag + '</select>';
}

//DataTables Function - handles onChange event for dropdowns
//called by addDropdownFilters
(function($) {
	$.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
	    // check that we have a column id
	    if ( typeof iColumn == "undefined" ) return new Array();
	     
	    // by default we only wany unique data
	    if ( typeof bUnique == "undefined" ) bUnique = true;
	     
	    // by default we do want to only look at filtered data
	    if ( typeof bFiltered == "undefined" ) bFiltered = true;
	     
	    // by default we do not wany to include empty values
	    if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;
	     
	    // list of rows which we're going to loop through
	    var aiRows;
	     
	    // use only filtered rows
	    if (bFiltered == true) aiRows = oSettings.aiDisplay; 
	    // use all rows
	    else aiRows = oSettings.aiDisplayMaster; // all row numbers
	    
	    // set up data array    
	    var asResultData = new Array();
	     
	    for (var i=0,c=aiRows.length; i<c; i++) {
	        iRow = aiRows[i];
	        var aData = this.fnGetData(iRow);
	        var sValue = aData[iColumn];
	         
	        // ignore empty values?
	        if (bIgnoreEmpty == true && sValue.length == 0) continue;
	 
	        // ignore unique values?
	        else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
	         
	        // else push the value onto the result data array
	        else asResultData.push(sValue);
	    }    
	    
	    return asResultData;
}}(jQuery));


//adds commas seperations to any numberic string
function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

Array.prototype.getUnique = function(){
	   var u = {}, a = [];
	   for(var i = 0, l = this.length; i < l; ++i){
	      if(this[i] in u)
	         continue;
	      a.push(this[i]);
	      u[this[i]] = 1;
	   }
	   return a;
	};
