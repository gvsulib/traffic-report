jQuery(window).resize(function(){
	drawChart(false);
});
jQuery(document).ready(function(){
	jQuery('.add').click(function(){
		jQuery(this).closest('tbody').find('.template').after((jQuery(this).closest('tbody').find('.template').clone()).removeClass());
	});
	drawChart(true);
});


function removeRange(row){
	jQuery(row).parent().parent().remove();
}
function getRanges(){
	var ranges = {
		days: {
			exclude: [],
			include: []
		},
		hours: {
			exclude: [],
			include: [],
		}
	};

	jQuery('#days-exclude').find('tr').each(function(){
		var range = jQuery(this).find('input');
		if (range.length){
			var begin = range[0].value;
			var end = range[1].value;
			ranges.days.exclude.push([begin, end]);
		}
	});
	jQuery('#days-include').find('tr').each(function(){
		var range = jQuery(this).find('input');
		if (range.length){
			var begin = range[0].value;
			var end = range[1].value;
			ranges.days.include.push([begin, end]);
		}
	});	
	jQuery('#hours-exclude').find('tr').each(function(){
		var range = jQuery(this).find('input');
		if (range.length){
			var begin = range[0].value;
			var end = range[1].value;
			ranges.hours.exclude.push([begin, end]);
		}
	});
	jQuery('#hours-include').find('tr').each(function(){
		var range = jQuery(this).find('input');
		if (range.length){
			var begin = range[0].value;
			var end = range[1].value;
			ranges.days.include.push([begin, end]);
		}
	});
	return ranges;
}
google.load("visualization", "1", {packages:["corechart"]});