function DisplayCurrentTime() {
	var refresh = 1000; //Refresh rate 1000 milli sec means 1 sec
	var dt = new Date(); //This will get the local time
	$('.local_time').html(dt.toLocaleTimeString());
	
	//Deal with the airport time
	airport_dt = dt.getTime() + ($('#utc_offset').val() * 60 * 60 * 1000) + (dt.getTimezoneOffset() * 60 * 1000);
	airport_dt = new Date(airport_dt);
	$('.apt_time').text(airport_dt.toLocaleTimeString());
	
	window.setTimeout('DisplayCurrentTime()', refresh);
}

function fill(){
	var dataString = 'num_of_rows='+$('#num_of_rows').val();
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'api.php',
		data: dataString,
		cache: false,
		success:
			function(data){
				if(!data['error']){
					$('.apt_name').html(data['airport']);
					$('#utc_offset').val(data['utc_offset']);
					for(i = 0; i < $('#num_of_rows').val(); i++){
						//****ARRIVALS
						arrivals_section_contents = '';
 						//arrival time
						chars = data['arrivals'][i]['arr_time'].split('');
						for (char = 0; char < chars.length; char++){
							if(chars[char] != ':')
								arrivals_section_contents = arrivals_section_contents.concat('<span class="letter letter-'+chars[char]+'"></span>');
						}
						//carrier logo
						arrivals_section_contents = arrivals_section_contents + '<span class="letter letter-blank"></span>';
						arrivals_section_contents = arrivals_section_contents + '<img src="'+ data['arrivals'][i]['carrier_logo' ]+'">';
						//flight
						chars = [];
						chars = Array.from(data['arrivals'][i]['flight_iata']);
						for (char = 0; char < 6; char++){
							if(char >= chars.length)
								arrivals_section_contents = arrivals_section_contents + '<span class="letter letter-blank"></span>';
							else
								arrivals_section_contents = arrivals_section_contents + '<span class="letter letter-'+ chars[char] +'"></span>';
						}
						//origin
						chars = [];
						chars = Array.from(data['arrivals'][i]['origin'].toUpperCase());
						//give ity a space between flight number and the origin
						arrivals_section_contents = arrivals_section_contents + '<span class="letter letter-blank"></span>';
						for (char = 0; char < 13; char++){
							if(char >= chars.length)
								arrivals_section_contents = arrivals_section_contents + '<span class="letter letter-blank"></span>';
							else
								arrivals_section_contents = arrivals_section_contents + '<span class="letter letter-'+ chars[char] +'"></span>';
						}
						//status
						chars = [];
						arrivals_section_contents = arrivals_section_contents + '<span class="letter letter-blank"></span>';
						chars = data['arrivals'][i]['status'].toUpperCase().split('');
						for (char = 0; char < 10; char++){
							if(char >= chars.length)
								arrivals_section_contents = arrivals_section_contents + '<span class="letter letter-blank"></span>';
							else{
								if (chars[char] != ":")
									arrivals_section_contents = arrivals_section_contents + '<span class="letter letter-'+ chars[char] +'"></span>';
							}
						}
						//****END ARRIVALS
						//****DEPARTURES
						departures_section_contents = '';
						//arrival time
						chars = data['departures'][i]['dep_time'].split('');
						for (char = 0; char < chars.length; char++){
							if(chars[char] != ':')
								departures_section_contents = departures_section_contents.concat('<span class="letter letter-'+chars[char]+'"></span>');
						}
						//carrier logo
						departures_section_contents = departures_section_contents + '<span class="letter letter-blank"></span>';
						departures_section_contents = departures_section_contents + '<img src="'+ data['departures'][i]['carrier_logo' ]+'">';
						//flight
						chars = [];
						chars = Array.from(data['departures'][i]['flight_iata']);
						for (char = 0; char < 6; char++){
							if(char >= chars.length)
								departures_section_contents = departures_section_contents + '<span class="letter letter-blank"></span>';
							else
								departures_section_contents = departures_section_contents + '<span class="letter letter-'+ chars[char] +'"></span>';
						}
						//destination
						chars = [];
						chars = Array.from(data['departures'][i]['destination'].toUpperCase());
						//give ity a space between flight number and the destination
						departures_section_contents = departures_section_contents + '<span class="letter letter-blank"></span>';
						for (char = 0; char < 13; char++){
							if(char >= chars.length)
								departures_section_contents = departures_section_contents + '<span class="letter letter-blank"></span>';
							else
								departures_section_contents = departures_section_contents + '<span class="letter letter-'+chars[char]+'"></span>';
						}
						//status
						chars = [];
						departures_section_contents = departures_section_contents + '<span class="letter letter-blank"></span>';
						chars = data['departures'][i]['status'].toUpperCase().split('');
						for (char = 0; char < 10; char++){
							if(char >= chars.length)
								departures_section_contents = departures_section_contents + '<span class="letter letter-blank"></span>';
							else{
								if (chars[char] != ":")
									departures_section_contents = departures_section_contents + '<span class="letter letter-'+ chars[char] +'"></span>';
							}
						}
						//****END DEPARTURES

						//fill in the table
						//arrivals: time, carrier logo, flight, origin, status
						$('#arrivals_'+i).html('<div class="departure-board">'+ arrivals_section_contents +'</div>');
						//departures: time, carrier logo, flight, destination, status
						$('#departures_'+i).html('<div class="departure-board">'+ departures_section_contents +'</div>');
					}
				}
				else{
					console.log('There was an error.');
				}
			}
	});
	return false;
}

$(document).ready(function() {

	DisplayCurrentTime();

	$('.departures_table').hide();
	$('.arrivals_table').show();
	fill();

	//Connect to the API to update data every 30 minutes, otherwise you will be over your monthly quota
	setInterval(function(){
	    fill();
	}, 1800000);

	//Alternate from arrivals to departures every 45 seconds
	setInterval(function(){
		$('.departures_table').toggle();
		$('.arrivals_table').toggle();
	}, 45000);

});
