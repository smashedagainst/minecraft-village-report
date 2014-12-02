<head><meta charset="UTF-8">
</head>
<link rel="stylesheet" type="text/css" href="js/jquery-ui/jquery-ui.css">
<style type="text/css">
.ui:hover { background-color:#bfb; }
.fold { 	/* see http://www.webdesignerdepot.com/2012/11/how-to-create-a-simple-css3-tooltip/  */
	display:none; 
    z-index: 98;
	background: white;
	width:600px;
}
.ui-widget-content.fold { background: white; }
.left { 
	float:left; 
	margin-left:0; 
	padding-left:0; 
	vertical-align: text-top; 
}
.box {
	background-color:#FFF;
	padding: 5px;
	margin-bottom: 1px;
	border-left:   1px solid #ddd;
	border-top:   1px solid #ddd;
	border-right: 2px solid #dcc;
	border-bottom:2px solid #dcc;
}
h2 { margin-top:0px; }
.top { width:250px; height:65px; }
fieldset.box { width:520px; }
.clear { clear:both; }
#container { width: 550px; }
pre { margin:0px; }
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
var refreshme = 0;
$(document).ready(function() {
    $(".fold").resizable( );
	refresh();
	update();
});
function fold(div) {	//alert( "wtf" );
	  $("#pre"+div).slideToggle( "fast" );
	  $("#"+div).slideToggle( "slow" );
}
function refresh( ) {
	if( refreshme == 1 ) {
		refreshme = 0;
		$("#refresh").text("Refresh is off. (click to turn on)");
	} else {
		refreshme = 1;
		$("#refresh").text("Refresh is on. (click to turn off)");
	}
	update();
}
function update() {
	if( refreshme == 1 ) {
		$.get("villages_container.php", function(data) {
			$("#container").html(data);
			$("fieldset").effect( "highlight", {color:"#dfd"}, 2000 );
			window.setTimeout(update, 7000);
		});
		$.get("villages_filestats.php", function(data) {
			$("#filestats").html(data);
		});	}

} 
</script>
<pre><? 
$world_dir = '/home/minecraft/best';
//	NBT parser from: https://github.com/TheFrozenFire/PHP-NBT-Decoder-Encoder
//	Put nbt.class.php in same directory
require("nbt.class.php");
$nbt = new nbt();
$filename = "$world_dir/data/villages.dat";
$nbt->loadFile("$world_dir/data/villages.dat");
$villages = $nbt->root[0]['value'][0]['value'][0]['value']['value'];

?><div class="left box top"><h2><a href="/">← home</a></h2><h4><span id="count">There are <?php echo count($villages); ?> villages loaded</span></h4></div><div class="left">&nbsp;</div><div id="filestats" class="left box top"><small><?php

$command = "ls -alh $filename";
$output=""; $retval=0;
exec ( $command ,  $output, $retval  );
if( $retval == 0 ) {
	echo "<b>$filename</b>\n";
	$output[0] = str_replace( "  ", " ", $output[0] );
	$s = explode( " ", $output[0]);
	echo "Modified ".$s[5]." ".$s[6]." ".$s[7]."\n";
	$crc = crc32(file_get_contents($filename)); 
	printf("crc: %u\n", $crc);
	echo $s[4]." bytes\n";
} 
?></small></div><div class="clear"></div><span id="refresh" name="refresh" class="ui" onClick="refresh();"></span>

<div id="container"><?php // include( "villages_container.php" ); ?></div></pre>
