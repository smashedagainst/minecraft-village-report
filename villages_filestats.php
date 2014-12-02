<? 
$world_dir = '/home/minecraft/best';
$filename = "$world_dir/data/villages.dat";
$command = "ls -alh $filename";
$output=""; $retval=0;
exec ( $command ,  $output, $retval  );
if( $retval == 0 ) {
	echo "<small><b>$filename</b>\n";
	$output[0] = str_replace( "  ", " ", $output[0] );
	$s = explode( " ", $output[0]);
	echo "Modified ".$s[5]." ".$s[6]." ".$s[7]."\n";
	$crc = crc32(file_get_contents($filename)); 
	printf("crc: %u\n", $crc);
	echo $s[4]." bytes\n</small>";
} 
?>