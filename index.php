<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="utf-8">
    <title>OnTraNetBD</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="jquery-ui.css">
    <script src="jquery-1.11.0.min.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="ontranetbd.js"></script>
    <script>
        $(function() {
            var availableTags = [
                <?php
                    include_once( "sparql.php" );
                    $allLabels = getAllLabels();
                    for($i = 0; $i < $allLabels['count']; $i++) {
                        if( $i > 0 ) echo ',';
                        echo '"'.$allLabels['result'][$i]['label'].'"';
                    };
                ?>
            ];
            $( "#key" ).autocomplete({
                source: availableTags
            });
          });
    </script>     
</head>

<body>

<h1>OnTraNetBD</h1>
  
<input type="text" id="key" placeholder="Location/Tourist Spot...">&nbsp;
<input type="button" id="search" value="Search">

<div id="result">

</div>

</body>
</html>
