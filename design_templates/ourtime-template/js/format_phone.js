/* Format phone number function */
function formatPhone(curPhone)
{	
	curPhone.value = formatPhoneStr(curPhone.value);
}

/* Returns a formatted phone number */
function formatPhoneStr(phoneNumber)
{
	var tempPhone = phoneNumber.replace(/[^0-9]/g,"");

	var extension = "";

	if(tempPhone.indexOf("x") > -1)
	{
		extension = " "+tempPhone.substr(tempPhone.indexOf("x"));

		tempPhone = tempPhone.substr(0,tempPhone.indexOf("x"));
	}

	switch(tempPhone.length)
	{
		case(10):
			return tempPhone.replace(/(...)(...)(....)/g,"$1-$2-$3")+extension;
		case(11):
			if(tempPhone.substr(0,1) == "1")
			{
				return tempPhone.substr(1).replace(/(...)(...)(....)/g,"$1-$2-$3")+extension;
			}

			break;
		default:			
	}

	return phoneNumber;
}


function ValidateCustomDate(d) {
    var match = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/.exec(d);
    if (!match) {
        // pattern matching failed hence the date is syntactically incorrect
        return false;
    }
    var month = parseInt(match[1], 10) - 1; // months are 0-11, not 1-12
    var day   = parseInt(match[2], 10);
    var year  = parseInt(match[3], 10);
    var date  = new Date(year, month, day);
	
    // now, Date() will happily accept invalid values and convert them to valid ones
    // therefore you should compare input month/day/year with generated month/day/year
    return date.getDate() == day && date.getMonth() == month && date.getFullYear() == year;
}

function validMaxDate(d)
{
	var match = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/.exec(d);
    if (!match) {
        // pattern matching failed hence the date is syntactically incorrect
        return false;
    }
    var month = parseInt(match[1], 10) - 1; // months are 0-11, not 1-12
    var day   = parseInt(match[2], 10);
    var year  = parseInt(match[3], 10);
    var date  = new Date(year, month, day);
	
	var allowdatevalid = CompareDates(maxallowdate,date);
		
	if(allowdatevalid == false)
	{
		return false;
	}
	else
		return true;	
}

function CompareDates(date1, date2)
{
	var date1 = date1;
    var date2 = date2;
    
	if(date2 > date1)
    {        
        return false;
    }
    else
    {
        return true;
    }
}

