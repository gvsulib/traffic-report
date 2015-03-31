jQuery(window).resize(function(){
	if (validate()){
		drawChart(false);
	}
});
jQuery(document).ready(function(){
	jQuery('.add').click(function(){
		if (validate()){
			jQuery(this).closest('tbody').find('.template').after((jQuery(this).closest('tbody').find('.template').clone()).removeClass());
		}
	});
	if (validate()){
		drawChart(true);
	}
});

function validate(){
	var valid = true;
	jQuery('.end').each(function(i,el){
		var end = jQuery(el);
		var begin = end.parent().prev().children();
		if (new Date(end.val()) < new Date(begin.val())){
			alert("End must be after start.");
			valid = false;
			end.focus();
		}
	});
	return valid;
}

function removeRange(row){
	if (!jQuery(row).parent().parent().index()){
		jQuery(row).parent().parent().find(':input').val(-1);
	} else {
		jQuery(row).parent().parent().remove();
	}
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