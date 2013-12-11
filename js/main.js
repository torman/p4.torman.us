$('input[class=headcount]').each(function() {
	$(this).keyup(function(){   
		calTotalHeadcount();
	});
});

function calTotalHeadcount() {
	var sum = 0;
	//		$('input').each(function() {
	$('input[class=headcount]').each(function() {
		if(!isNaN(this.value) && this.value.length!=0) {
			sum += parseInt(this.value);
		}
	});
	
	console.log(sum);
	$(".total_headcount").html(sum);
}

