<?

$fh = fopen('data.txt','r');

$recArray = array();
$dump = fgetcsv($fh);
while (!feof($fh))
{
  
  $addrData = fgetcsv($fh);

  $address = explode(",",$addrData[2],3);

  $recArray[] = 
    array('title' => trim($addrData[1]),
  	      'address' => trim($address[0]),
		  
  	      'phone' => trim($addrData[6]),
		  'email' => trim($addrData[5]),
		  'url' => trim($addrData[7]),
		  'description' => trim($addrData[8]),
  	      'type' => trim($addrData[9]),
  	      'latitude' => trim($addrData[11]),
		  'longitude' => trim($addrData[10])
  	     );
}

echo json_encode($recArray);

?>