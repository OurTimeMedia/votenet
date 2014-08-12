$(document).ready(function(){

	// Get items
	function getItems(exampleNr)
	{
		var columns = [];

		$(exampleNr + ' ul.sortable-list').each(function(){
			columns.push($(this).sortable('toArray').join(','));				
		});

		return columns.join('|');
	}
	// Example 2.1: Get items
	$('#example-2-1 .sortable-list').sortable({
		connectWith: '#example-2-1 .sortable-list'
	});

	$('#btnpartysave').click(function(){
	//alert(document.getElementById('selParty'));
	//alert(getItems('#example-2-1'));
	var values=getItems('#example-2-1');
	var ar=values.split("|");
	//alert(ar[1]);
	document.getElementById('selParty').value=ar[0];
	});
	
	$('#btnracegroupsave').click(function(){

	var values=getItems('#example-2-1');
	var ar=values.split("|");
	//alert(ar[1]);
	document.getElementById('selRaceGroup').value=ar[0];
	});
	
	$('#btnidnumbersave').click(function(){
	
	var values=getItems('#example-2-1');
	var ar=values.split("|");
	//alert(ar[1]);
	document.getElementById('selidnumber').value=ar[0];
	});
	
	
	$('#btnEligibilityCriteria').click(function(){
	
	var values=getItems('#example-2-1');
	var ar=values.split("|");
	//alert(ar[1]);
	document.getElementById('selEligibilityCriteria').value=ar[0];
	});
});
