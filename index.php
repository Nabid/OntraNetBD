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

    <script type="text/javascript" src="./assets/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./assets/bootstrap/css/bootstrap.min.css">

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

    <script type="text/javascript">
        function triggerSearch(e){
            var name = $(e).text();

            if( name.indexOf('\(') >= 0 ) {
                name = name.substr(0, name.indexOf('\('));
            }

            name = name.trim();

            $('#key').val(name);

            $('#search').trigger('click');
        };
    </script>

    <style rel="stylesheet" type="text/css" >
    body {
        overflow-x: hidden;
    }

    .list-group-item {
        cursor: pointer;    
    }
    </style>
</head>

<body>

<div class="row">
  <div class="col-md-3"></div>
  <div class="col-sm-6">
    <h3>OnTraNetBD <span class="label label-default">Travel Ontology of Bangladesh</span></h3>

    <div class="row">
      <div class="col-sm-12">
        <div class="input-group">
          <input id="key" type="text" class="form-control" placeholder="Search for Location or Tourist Spot...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button" id="search" value="Search">Search</button>
          </span>
        </div><!-- /input-group -->
      </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->

    <!--<form method="post">
        <div class="form-group"></div>
        
    </form>
     <div class="panel panel-primary">...</div> -->
    <div id="result" ></div>

</div>
  </div>
  <div class="col-md-3"></div>
</div>

</body>
</html>
