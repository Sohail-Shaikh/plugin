


<html>
    <head>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.14/jquery-ui.min.js"></script>
    <style>
 
        BODY {font-family : Verdana,Arial,Helvetica,sans-serif; color: #000000; font-size : 13px ; }
 
        #map_canvas { width:100%; height: 100%; z-index: 0; }
    </style>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCWxYcLKUH2nF561L7aK_pM0imSXuFSyS4" /></script>
      
    <script type='text/javascript'>
 
    //This javascript will load when the page loads.
    jQuery(document).ready( function($){
 
            //Initialize the Google Maps
            var geocoder;
            var map;
            var markersArray = [];
            var infos = [];
 
            geocoder = new google.maps.Geocoder();
            var myOptions = {
                  zoom: 9,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                }
            //Load the Map into the map_canvas div
            var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
 
            //Initialize a variable that the auto-size the map to whatever you are plotting
            var bounds = new google.maps.LatLngBounds();
            //Initialize the encoded string       
            var rowData;
            //Initialize the array that will hold the contents of the split string
            var stringArray = [];
            //Get the value of the encoded string from the hidden input
            rowData = document.getElementById("rowData").value;
            // alert(rowData);
            //Split the encoded string into an array the separates each location
            stringArray = rowData.split("****");
 
            var x;
            for (x = 0; x < stringArray.length; x = x + 1)
            {
                var addressDetails = [];
                var marker;
                //Separate each field
                addressDetails = stringArray[x].split("&&&");
                //Load the lat, long data
                var lat = new google.maps.LatLng(addressDetails[1], addressDetails[2]);
                // alert(lat);
                //Create a new marker and info window
                marker = new google.maps.Marker({
                    map: map,
                    position: lat,
                    //Content is what will show up in the info window
                    content: addressDetails[0]
                });
                //Pushing the markers into an array so that it's easier to manage them
                markersArray.push(marker);
                google.maps.event.addListener( marker, 'click', function () {
                    closeInfos();
                    var info = new google.maps.InfoWindow({content: this.content});
                    //On click the map will load the info window
                    info.open(map,this);
                    infos[0]=info;
                });
               //Extends the boundaries of the map to include this new location
               bounds.extend(lat);
            }
            //Takes all the lat, longs in the bounds variable and autosizes the map
            map.fitBounds(bounds);
 
            //Manages the info windows
            function closeInfos(){
           if(infos.length > 0){
              infos[0].set("marker",null);
              infos[0].close();
              infos.length = 0;
           }
            }
 
    });
    </script>
 
    </head>
    <body>
    <div id='input'>
 
        <?php
        // // require_once '../Classes/PHPExcel.php';
        // // require_once 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
        // ini_set('include_path', ini_get('include_path').';../Classes/');
        // include 'PHPExcel.php';
         require('PHPExcel-1.8/Classes/PHPExcel/IOFactory.php') or die();
       //Connect to the MySQL database that is holding your data, replace the x's with your data
		// mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
		// mysql_select_db("map");
		 
		// //Initialize your first couple variables
		// $encodedString = ""; //This is the string that will hold all your location data
		// $x = 0; //This is a trigger to keep the string tidy
		 
		// //Now we do a simple query to the database
		// $result = mysql_query("SELECT * FROM `big-ten`");
		 
		// //Multiple rows are returned
		// while ($row = mysql_fetch_array($result, MYSQL_NUM))
		// {
		//     //This is to keep an empty first or last line from forming, when the string is split
		//     if ( $x == 0 )
		//     {
		//          $separator = "";
		//     }
		//     else
		//     {
		//          //Each row in the database is separated in the string by four *'s
		//          $separator = "****";
		//     }
		//     //Saving to the String, each variable is separated by three &'s
		//     $encodedString = $encodedString.$separator.
		//     "<p class='content'><b>Lat:</b> ".$row[1].
		//     "<br><b>Long:</b> ".$row[2].
		//     "<br><b>Name: </b>".$row[3].
		//     "<br><b>Address: </b>".$row[4].
		//     "<br><b>Division: </b>".$row[5].
		//     "</p>&&&".$row[1]."&&&".$row[2];
		//     $x = $x + 1;
		// }




    //Check valid spreadsheet has been uploaded
if(isset($_FILES['spreadsheet'])){
if($_FILES['spreadsheet']['tmp_name']){
    if(!$_FILES['spreadsheet']['error'])
    {

        $inputFile = $_FILES['spreadsheet']['name'];
        $extension = strtoupper(pathinfo($inputFile, PATHINFO_EXTENSION));
        if($extension == 'XLSX' || $extension == 'XLS'){

            //Read spreadsheeet workbook
            try {
                 $inputFile = $_FILES['spreadsheet']['tmp_name'];
                 $inputFileType = PHPExcel_IOFactory::identify($inputFile);
                 $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                 $objPHPExcel = $objReader->load($inputFile);
            } catch(Exception $e) {
                    die($e->getMessage());
            }

            //Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();
            $data='';
            //Loop through each row of the worksheet in turn
            for ($row = 1; $row <= $highestRow; $row++){ 
                    //  Read a row of data into an array
                    if($row==1)
                    {
                       continue; 
                    }
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    if ( $row == 2 )
                    {
                         $separator = "";
                    }
                    else
                    {
                         //Each row in the database is separated in the string by four *'s
                         $separator = "****";
                    }
                    //Insert into database
                    $data = $data.$separator.
                    "<p class='content'><b>Lat:</b> ".$rowData[0][1].
                    "<br><b>Long:</b> ".$rowData[0][2].
                    "<br><b>Name: </b>".$rowData[0][3].
                    "<br><b>Address: </b>".$rowData[0][4].
                    "<br><b>Division: </b>".$rowData[0][6].
                    "</p>&&&".$rowData[0][1]."&&&".$rowData[0][2];
            }

        }
        else{
            echo "Please upload an XLSX or ODS file";
        }
    }
    else{
        echo $_FILES['spreadsheet']['error'];
    }
}
}


        ?>
 
        <input type="hidden" id="encodedString" name="encodedString" value="<?php echo $encodedString; ?>" />
        <input type="hidden" id="rowData" name="rowData" value="<?php echo $data; ?>" />
        <form method="post" enctype="multipart/form-data">
            Upload File: <input type="file" name="spreadsheet"/>
            <input type="submit" name="submit" value="Submit" />
        </form>
    </div>
    <div id="map_canvas"></div>
    </body>
</html>