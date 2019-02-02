<?php

if (isset($_POST["place"])) { 
    $search = $_POST["place"];
}else{
	$search = "";
}


?>
<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--
			Author : Kashyap Thakkar, 000742712
		
		-->
		<title>Explore Hamilton</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		
		<link href="css/bootstrap.min.css" rel="stylesheet">
		
		<script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=Ah5oCQC-Y85PG0iftLGrgp85fPP6VclM_BhrwE9-A3-NAKFnG6I1pxny26sPWM99&callback=loadMapScenario' async defer></script>
		
	</head>
	<body>
		
		<nav class="navbar navbar-inverse navbar-static-top" style="margin:0; overflow: hidden;">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						
					</button>
					<a class="navbar-brand" id = "header" href="index.html">All</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						 
						  
						<li><a href="acomodations.html">Accomodations</a></li>
						<li><a href="attractions.html">Attractions</a></li>
						<li><a href="museums.html">Museums</a></li>
						<li><a href="outdoors.html">Outdoors</a></li>
						<li><a href="shopping.html">Shopping</a></li>
						<li><a href="sport.html">Sport and Recreation</a></li>
						<li><a href="waterfalls.html">Waterfalls</a></li>
						<li><a href="about.html">About</a></li>
					</ul>
					<form class="navbar-form navbar-right" method="post" role="search" action="search.php">
						 <div class="form-group">
							<input type="text" id="place" name="place" class="form-control" placeholder="Search">
						 </div>
						<button type="submit" class="btn btn-default">Submit</button>
					</form>
				</div>
				
			
			</div>
		</nav>
		<div>
			<img src="images/logo.PNG" class="img-responsive" alt="Responsive image" style="display: block; margin-left: auto; margin-right: auto;">
		</div >
		
		<div class="row">
			<div id='myMap' class="col-lg-11 col-md-11 col-sm-12 col-xs-12" style=' margin-top: 5px;    height: 68%;'></div>
			<div class="col-lg-1 col-md-1 hidden-sm hidden-xs" style=" margin-top: 5px;">
				<a href="https://www.facebook.com/Explore-Hamilton-582128182231418/?modal=admin_todo_tour" ><img style=" margin: 5px;" src="images/facebook.png" alt="Facebook Link" ></a>
				<a href="#" ><img style=" margin: 5px;" src="images/twitter.png" alt="Twitter Link" ></a>
				<a href="https://www.instagram.com/explorehamilton1199/" ><img style=" margin: 5px;" src="images/instagram.png" alt="Instagram Link" ></a>
				<a href="mailto: kashyap-ashokkumar.thakkar@mohawkcollege.ca" ><img style=" margin: 5px;" src="images/close-envelope.png" alt="Mail Link" ></a>
			</div>
			
		</div>
		<script>
			function loadMapScenario() {
				var search = "<?php echo $search ?>";
                var map = new Microsoft.Maps.Map(document.getElementById('myMap'), {});
				infobox = new Microsoft.Maps.Infobox(map.getCenter(), {
					visible: false,
					maxWidth: 6800, 
					maxHeight: 1100,
				});
				infobox.setMap(map);
				getCurrenLocation();
				function getCurrenLocation(){
					if(navigator.geolocation){
						navigator.geolocation.getCurrentPosition(showPosition, showError);
					
					}else{
						locate.innerHTML = "GPS Co-ordinates Unavailable!!";
					}
				}
				function showPosition(position) {
					var pin = new Microsoft.Maps.Pushpin((new Microsoft.Maps.Location(position.coords.latitude,position.coords.longitude)), { icon: 'https://bingmapsisdk.blob.core.windows.net/isdksamples/defaultPushpin.png'});

					
					map.entities.push(pin);
					pin.metadata = {
						title: "Current Location",
						description: " "
					
					};
					Microsoft.Maps.Events.addHandler(pin,'click',pushpinClicked);
				
				}
				function showError(error) {
					switch(error.code) {
						case error.PERMISSION_DENIED:
							alert("PERMISSION_DENIED: The location acquisition failed because the User denied the request for Geolocation API.");
							break;
						case error.POSITION_UNAVAILABLE:
							alert("POSITION_UNAVAILABLE: the location acquisition failed because the Location information is unavailable.");
							break;
						case error.TIMEOUT:
							alert("TIMEOUT: The location acquisition failed because the request to get user location timed out.");
							break;
						case error.UNKNOWN_ERROR:
							alert("UNKNOWN_ERROR: The location acquisition failed because an unknown error occurred.");
							break;
					}
				}
				$.ajax({
					url:'data.php',
					method:'get',
				
					success:function(data)
					{
						var jsonData = JSON.parse(data);
						if(search == ""){
							for(var i=0;i<jsonData.length;i++){
								
								var pin  = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(jsonData[i].latitude,jsonData[i].longitude));
											
								pin.metadata = {
									title: jsonData[i].title,
									description:   jsonData[i].address+ '<br>'  + '<a href="tel:'+jsonData[i].phone+'" >'+jsonData[i].phone+'</a>'+ '<br>'  + '<a href="mailto:'+jsonData[i].email+'" >Email</a>' + '<br>' + '<a href = "http://bing.com/maps/default.aspx?where1=' + jsonData[i].address + '" target="_blank">Directions</a>' + '<br>' + '<a href = "'+jsonData[i].url+'" target="_blank">Website</a>'
												 
								};
								Microsoft.Maps.Events.addHandler(pin,'click',pushpinClicked);
											
								map.entities.push(pin);
										
										
							
							}
						}else{
							for(var i=0;i<jsonData.length;i++){
								if(jsonData[i].title.toLowerCase() == search.toLowerCase()){
									var pin  = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(jsonData[i].latitude,jsonData[i].longitude));
												
									pin.metadata = {
										title: jsonData[i].title,
										description:   jsonData[i].address+ '<br>'  + '<a href="tel:'+jsonData[i].phone+'" >'+jsonData[i].phone+'</a>'+ '<br>'  + '<a href="mailto:'+jsonData[i].email+'" >Email</a>' + '<br>' + '<a href = "http://bing.com/maps/default.aspx?where1=' + jsonData[i].address + '" target="_blank">Directions</a>' + '<br>' + '<a href = "'+jsonData[i].url+'" target="_blank">Website</a>'
													 
									};
									Microsoft.Maps.Events.addHandler(pin,'click',pushpinClicked);
												
									map.entities.push(pin);
											
								}else if(jsonData[i].address.toLowerCase() == search.toLowerCase()){
									var pin  = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(jsonData[i].latitude,jsonData[i].longitude));
												
									pin.metadata = {
										title: jsonData[i].title,
										description:   jsonData[i].address+ '<br>'  + '<a href="tel:'+jsonData[i].phone+'" >'+jsonData[i].phone+'</a>'+ '<br>'  + '<a href="mailto:'+jsonData[i].email+'" >Email</a>' + '<br>' + '<a href = "http://bing.com/maps/default.aspx?where1=' + jsonData[i].address + '" target="_blank">Directions</a>' + '<br>' + '<a href = "'+jsonData[i].url+'" target="_blank">Website</a>'
													 
									};
									Microsoft.Maps.Events.addHandler(pin,'click',pushpinClicked);
												
									map.entities.push(pin);
											
								}
										
							}
						}
						
					},
					error:function(data)
					{
					alert("error");
					}
				});
				
				
            }
			
			function pushpinClicked(e){
				if(e.target.metadata){
					infobox.setOptions({
						
						location: e.target.getLocation(),
						title: e.target.metadata.title,
						description: e.target.metadata.description,
						visible: true
					});
				}
			}
            
			
		</script>
	</body>
</html>