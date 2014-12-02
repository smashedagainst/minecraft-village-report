<? 
$world_dir = '/home/minecraft/best';
require("nbt.class.php");
$nbt = new nbt();
$nbt->loadFile("$world_dir/data/villages.dat");
$villages = $nbt->root[0]['value'][0]['value'][0]['value']['value'];

if( count($villages) > 0 ) {
?><script type="text/javascript">
var el = document.getElementById('count');
el.innerHTML = "There are <?php echo count($villages); ?> villages loaded";
</script><?

	$doorDivdx=0;
	$vattrs = Array( "CX", "CY", "CZ", "Radius", "PopSize" );
	$dattrs = Array( "X", "Y", "Z" );
	$pattrs = Array( "S", "Name" );
	foreach( $villages as $village ) {
		$door_output = "";
		$p_output = "";
		foreach( $village as $attr ) {
			if( in_array( $attr['name'], $vattrs ) )
				${$attr['name']} = $attr['value'];
			if( $attr['name'] == "Doors" ) {
				$ddx=0;
				foreach( $attr['value']['value'] as $door ) {
					foreach( $door as $_dattr )
						if( in_array( $_dattr['name'], $dattrs ) )
							${$_dattr['name']} = $_dattr['value'];
					$ddx++;
					$door_output .= sprintf( "    Door %2d: %4d %2d %-4d \n",$ddx, $X, $Y, $Z);
				}	
			}
			if( $attr['name'] == "Players" ) {
				$pdx=0;
				foreach( $attr['value']['value'] as $player ) {
					foreach( $player as $_pattr )
						if( in_array( $_pattr['name'], $pattrs ) )
							${$_pattr['name']} = $_pattr['value'];
					$pdx++;
					$p_output .= "    $Name Score: $S\n";
				}	
			}
		}
		echo "<fieldset class=\"box\">x,y,z( $CX $CY $CZ )";
		$ckx = (int)($CX/16); // sprintf( "%.0f", $CX/16); 
		$cky = (int)($CY/16);
		$ckz = (int)($CZ/16); // sprintf( "%.0f", $CZ/16); 
		echo "  <small>chunk( $ckx $cky $ckz ) ";
		echo "  radius: $Radius  population: $PopSize</small>\n";
		if( strlen( $p_output ) > 1 )
			echo "  <small>Player(s):</small>\n$p_output";
		if( $ddx < 8 )
			echo "  $ddx doors:\n$door_output";
		else {
			$doordiv="doordiv$doorDivdx";
			$doorDivdx++;
			echo "  $ddx doors: (<span class=\"ui\" onClick=\"fold('$doordiv' );\">click to show/hide all doors</span>)";
			$doors=explode("\n",$door_output);
			echo " <div id=\"pre$doordiv\">";
			for( $idx=(count($doors)-1); $idx>(count($doors)-9); $idx-- ) {
				echo $doors[$idx]."\n";
			}
			$skip=count($doors)-8;
			echo "    <span class=\"ui\" onClick=\"fold('$doordiv' );\">... $skip doors hidden</span></div>";
			echo "    <div id=\"$doordiv\" class=\"ui-widget-content fold \"><div class=\"left\">";
			for( $idx=0; $idx<count($doors); $idx++ ) {
				if( $idx>0 && $idx%10 == 0 )
					echo "    </div><div class=\"left\">";
				echo $doors[$idx];
				if( $idx<(count($doors)-1) )
					echo "\n";
			}
			echo "    </div><div style=\"clear:both\"></div></div>";
		}
		echo "</fieldset>";
	}
}
?>
