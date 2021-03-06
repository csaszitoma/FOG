<?php

require_once( "../commons/config.php" );
require_once( "../commons/functions.include.php" );

$conn = mysql_connect( MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD);
if ( $conn )
{
	if ( ! mysql_select_db( MYSQL_DATABASE, $conn ) ) die( _("Unable to select database") );
}
else
{
	die( _("Unable to connect to Database") );
}

$mac = $_GET["mac"];

if ( ! isValidMACAddress( $mac ) )
{
	die( _("Invalid MAC address format!") );
}

if ( $mac != null  )
{
	$hostid = getHostID( $conn, $mac );
	cleanIncompleteTasks( $conn, $hostid );	
	if ( queuedTaskExists( $conn, $mac ) )
	{
		$num = getNumberInQueue( $conn, 1 );
		$jobid = getTaskIDByMac( $conn, $mac );
		if ( $hostid != null && $jobid != null )
		{
			if ( checkIn( $conn, $jobid ) )
			{
				if ( doImage( $conn, $jobid ) )
					echo "##";
				else
					echo _("Error attempting to start imaging process");				
				exit;			
			}
			else
			{
				echo _("Error: Checkin Failed.");
			}
		}
		else
		{
			echo _("Unable to locate host in database, please ensure that mac address is correct.");
		}
	}
	else
	{
		echo (_("No job was found for MAC Address").": $mac");
	}
}
else
	echo _("Invalid MAC Address");
?>
