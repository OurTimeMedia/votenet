function formatCurrency(num,symbol) {
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
	num = "0";
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10)
	cents = "0" + cents;
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	num = num.substring(0,num.length-(4*i+3))+','+
	num.substring(num.length-(4*i+3));
	return (((sign)?'':'-') + symbol + num + '.' + cents);
}

function isNegativeValue(num)
{
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
	num = "0";
	sign = (num == (num = Math.abs(num)));
	
	return sign;	
}

function getFloatNumber(num) {
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
	num = "0";
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10)
	cents = "0" + cents;	
	var returnval = parseFloat(num + '.' + cents);
	
	return returnval;
}

function resetSalary()
{
	if(document.getElementById("doq").checked == true)
	{
		document.getElementById("low_salery").value = "$0.00";
		document.getElementById("hi_salery").value = "$0.00";
		document.getElementById("pay_schedule").value = "HOURLY";
		
		document.getElementById("low_salery").disabled = true;
		document.getElementById("hi_salery").disabled = true;
		document.getElementById("pay_schedule").disabled = true;
	}
	else
	{
		document.getElementById("low_salery").disabled = false;
		document.getElementById("hi_salery").disabled = false;
		document.getElementById("pay_schedule").disabled = false;
	}
}