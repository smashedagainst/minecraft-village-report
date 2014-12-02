<legend>server status</legend><?
require 'MinecraftQuery.class.php';
$Query = new MinecraftQuery( );
$Query->Connect( 'localhost', 25565 );
$server = $Query->GetInfo();
$players = $Query->GetPlayers();
?><P class="cli"><? 

if( $players[0] == "" )
	echo "<b>No one playing :(</b>\n";
elseif( count( $players ) == 1 && strlen( $players[0] > 1 ) )
	echo "<b>one player:</b> ".$players[0]." \n";
elseif( count( $players ) > 1 ) {
	echo "<b>players:</b>\n";
	foreach( $players as $player )
		echo "  $player\n";
}
echo "</p>";

$commands = Array( "uptime", "free", "df -h | grep -v run" );
foreach( $commands as $command ) {
	$output=""; $retval=0;
	exec ( $command ,  $output, $retval  );
	if( $retval == 0 ) {
		echo "<p class=\"cli\"><b>$command:</b>\n";
		foreach( $output as $line )
			if( strpos( $line, '..' ) === FALSE )
				echo "$line\n";
	} else {
		echo "Error occurred:\n$command ... returned $retval\nFAIL\n";
	}
	echo "</p>";
}
?>