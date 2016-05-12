<?php
include_once( "sparql.php" );

if( isset( $_POST["key"] ) ) {
	$key = trim( $_POST["key"] );
	if( $key == "" ) {
		echo "Please enter something to search.";	
	}
	else {
		$result = isIndividualOrClass( $key );
		if( $result["verdict"] ) {			
			if( $result["verdict"] == 1 ) { //if key is a named individual
				$types = getTypeOfIndividual( $key );
				foreach( $types as $type ) {
					//echo '<br>As "' . $type . '": ';
					if( $type == "Area" || $type == "District" ) {
						// find District and Tourist Spots if type is Area
						if( $type == "Area" ) { // Area
							$dist = getDistrict( $key );
							echo '* An area in District '.$dist.' in Bangladesh.<br>';
							$spots = getSpotsInArea( $key );
						}
						else { // District
							echo '* A District.<br>';
							$spots = getSpotsInDistrict( $key );
						}
						$cnt = $spots['count'];
						if( $cnt < 2 ) { $aux = "is"; $entry = "spot"; }
						else { $aux = "are"; $entry = "spots"; }
						if( $cnt == 0 ) { $cnt = "no"; $end = "."; }
						else $end = "-";
						echo "There ".$aux." ".$cnt." tourist ".$entry." in ".$key.".<br>";
						//print "<pre>";  print_r($spots);
						if( $spots['count'] > 0 ) {
							echo "<ul>";
							foreach($spots['result'] as $sp) {
								echo "<li>".$sp['spot'];
								$spotTypes = getTypeOfIndividual( $sp['spot'] );
								foreach ($spotTypes as $k => $value) {
									//echo "!!".$value."!!";
									if( $value != $type ) { $st = $value; break; }

								}
								echo ' ('.$st.')</li>';
							}
							echo "</ul>";
						}
						//echo "<br><br>";
					}
					else { // Travel Attraction & Accomodation
						//$spotTypes = getTypeOfIndividual( $key );
						//foreach ($types as $k => $value) {
						//	if( $value != $type ) { $st = $value; break; }
						//}
						$loc = getLocation( $key );
						if( checkVowel( $type[0] ) ) $art = 'An';
						else $art = 'A'; 
						echo '* ' . $art . ' ' . $type . '.<br>';
						echo "Location: " . $loc . '<br>';
						//echo "Activities: " . '<br>';
						//echo "<br>";
						$others = getSpotsOfType( $key, $type );
						//print "<pre>";  print_r($others);
						if( $others['count'] > 0 ) {
							echo "<br>Similar tourist spot(s) in Bangladesh:";
							echo "<ul>";
							foreach ($others['result'] as $other) {
								if( $other['otsp'] != $key )
									echo "<li>".$other['otsp'].'</li>';
							}
							echo "</ul>";
						}
						//echo "<br><br>";
					}
				}
			}
			else { //if key is a class
				if( checkVowel( $result["message"][0] ) ) $aAn = "an";
				else $aAn = "a";
				//echo '"' . $key . '" is ' . $aAn . ' ' . $result["message"] . ".<br>";
				$members = getAllMembers( $key ); 
				$cntM = count( $members );
				if( $cntM == 0 || $cntM == 1 || ( $cntM == 1 && $members == "Not Found" ) ) {
					$aux = "is";
					$entry = "entry";
				}
				else {
					$aux = "are";
					$entry = "entries";
				}				
				if( $members != "Not Found" ) {
					echo 'There ' . $aux . ' ' . count( $members ) . ' ' . $entry . ' "' . $key . '".';
					/*print "<pre>";
					print_r( $members );
					print "</pre>";*/
					echo '<ul>';
					foreach( $members as $mem ) {
						echo '<li>' . $mem["member"] . '</li>';
					}
					echo '</ul>';
				}
				else {
					echo 'There ' . $aux . ' no ' . $entry . ' for type "' . $key . '".';
				}
			}
		}
		else {
			echo $result["message"];
		}		
	}	
}
else {
	echo "Nothing has been searched.";
}

function checkVowel( $ch ) {
	$ch = strtolower( $ch );
	if( $ch == "a" || $ch == "a" || $ch == "e" || $ch == "i" || $ch == "o" || $ch == "u" ) return 1;
	else return 0;
}