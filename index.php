<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="refresh" content="0; url=traffic.php">
	<title>Traffic Report <!-- SQL Generator --></title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<style>
		html,body {
			font-family: sans-serif;
		}
		table > tbody > tr:nth-child(1)  a{
			display: none;
		}
	</style>
</head>
<body>
	<!--h2>Include Dates</h2>
	<table id="include" class="table">
		<thead>
			<tr>
				<th>From</th>
				<th>To</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<tr class="template">
				<td><input type="date" class="begin" /></td>
				<td><input type="date" class="end" /></td>
				<td><a href="#" onclick="removeRange(this)">x</a></td>
			</tr>
		</tbody>
	</table>
	<button id="add" onclick="addInclude()">Add</button>
	<h2>Exclude Dates</h2>
	<table id="exclude" class="table">
		<thead>
			<tr>
				<th>From</th>
				<th>To</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<tr class="template">
				<td><input type="date" class="begin" /></td>
				<td><input type="date" class="end" /></td>
				<td><a href="#" onclick="removeRange(this)">x</a></td>
			</tr>
		</tbody>
	</table>
	<button id="add" onclick="addExclude()">Add</button>
	
	<button id="go" onclick="go()">Go</button>
	<pre id="result"></pre>
	<script>
		function addExclude(){
			jQuery('#exclude .template').after((jQuery('#exclude .template').clone()).removeClass());
		}
		function addInclude(){
			jQuery('#include .template').after((jQuery('#include .template').clone()).removeClass());
		}
		function removeRange(row){
			jQuery(row).parent().parent().remove();
		}
		function go(){
			var query = "select\n" +
			"  avg(t.level) avg,\n" +
			"  t.space\n" +
			"from\n" +
			"  entries e,\n" +
			"  traffic t\n" +
			"where \n" +
			"  e.entryId = t.entryId\n";

			jQuery('#exclude tbody tr').each(function(){
				var begin = jQuery(this).find('.begin').val();
				var end = jQuery(this).find('.end').val();
				query += "  and e.time not between '" + begin + "' and '" + end + "'\n";
			});
			jQuery('#include tbody tr').each(function(){
				var begin = jQuery(this).find('.begin').val();
				var end = jQuery(this).find('.end').val();
				query += "  and e.time between '" + begin + "' and '" + end + "'\n";
			});
			query += "group by\n  t.space"
			jQuery('#result').html(query);
		}
	</script-->
</body>
</html>
