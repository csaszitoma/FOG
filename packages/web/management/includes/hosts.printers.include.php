<?php
/*
 *  FOG is a computer imaging solution.
 *  Copyright (C) 2007  Chuck Syperski & Jian Zhang
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 */

if ( IS_INCLUDED !== true ) die( _("Unable to load system configuration information.") );

if ( $currentUser != null && $currentUser->isLoggedIn() )
{
	$id = mysql_real_escape_string( $_GET["id"] );
	
	if ( $_POST["update"] == "1" )
	{
		if ( $_POST["level"] !== null )
		{
			$level = mysql_real_escape_string( $_POST["level"] );
			$sql = "update hosts set hostPrinterLevel = '$level' where hostID = '$id'";
			if ( mysql_query( $sql, $conn ) )
			{
				if ( $_POST["prnt"] !== null && is_numeric( $_POST["prnt"] ) && $_POST["prnt"]  >=  0 )
				{
					$printer = mysql_real_escape_string( $_POST["prnt"] );
					
					if ( ! addPrinter( $conn, $id, $printer ) )
						msgBox( _("Failed to add printer") );
											
				}		
			}
			else
			{
				msgBox( mysql_error() );
			}
		}
	}
	
	if ( $_GET["default"] !== null )
	{
		setDefaultPrinter( $conn, $_GET["default"] );
	}
	
	if ( $_GET["dellinkid"] !== null )
	{
		deletePrinter( $conn, $_GET["dellinkid"] );
	}
	
	if ( is_numeric( $id ) )
	{
		$sql = "select * from hosts where hostID = '$id'";
		$res = mysql_query( $sql, $conn ) or die( mysql_error() );
		if ( $ar = mysql_fetch_array( $res ) )
		{
			?>
			<h2><?php print _("Host Printer Configuration"); ?></h2>
			<?php
			echo ( "<form method=\"POST\" action=\"?node=$_GET[node]&sub=$_GET[sub]&id=$_GET[id]\">" );
			echo ( "<p>"._("Select Management Level for this Host").":</p>" );
			echo ( "<p class=\"l\">" );
			
			$sel = array( "", "", "" );
			
			if ( $ar["hostPrinterLevel"] == "0" )
				$sel[0] = " checked=\"checked\" ";
			else if ( $ar["hostPrinterLevel"] == "1" )
				$sel[1] = " checked=\"checked\" ";
			else if  ( $ar["hostPrinterLevel"] == "2" )
				$sel[2] = " checked=\"checked\" ";
			else
				$sel[0] = " checked=\"checked\" ";
			
			echo ( "<input type=\"radio\" name=\"level\" value=\"0\" $sel[0] />"._("No Printer Management")."<br/>" );
			echo ( "<input type=\"radio\" name=\"level\" value=\"1\" $sel[1] />"._("Add Only")."<br/>" );
			echo ( "<input type=\"radio\" name=\"level\" value=\"2\" $sel[2] />"._("Add and Remove")."<br/>" );
			echo ( "</p>" );
			
			echo ( "<table cellpadding=0 cellspacing=0 border=0 width=100%>" );
					echo ( "<tr class=\"header\"><td>&nbsp;<b>"._("Default")."</b></td><td>&nbsp;<b>"._("Printer Alias")."</b></td><td>&nbsp;<b>"._("Printer Model")."</b></td><td><b>"._("Remove")."</b></td></tr>" );
					$sql = "SELECT 
							* 
						FROM 
							printerAssoc
							inner join printers on ( printerAssoc.paPrinterID = printers.pID )
						WHERE
							printerAssoc.paHostID = '$id'
						ORDER BY
							printers.pAlias";
					$res = mysql_query( $sql, $conn ) or die( mysql_error() );
					if ( mysql_num_rows( $res ) > 0 )
					{
						$i = 0;
						while ( $ar = mysql_fetch_array( $res ) )
						{
							$bgcolor = "alt1";
							if ( $i++ % 2 == 0 ) $bgcolor = "alt2";
							
							$default = "<a href=\"?node=$_GET[node]&sub=$_GET[sub]&id=$_GET[id]&default=$ar[paID]\"><img src=\"./images/no.png\" class=\"noBorder\" /></a>";
							if ( $ar["paIsDefault"] == "1" )
								$default = "<img src=\"./images/yes.png\" class=\"noBorder\" />";
							
							echo ( "<tr class=\"$bgcolor\"><td>&nbsp;" . $default . "</td><td>&nbsp;" . trimString( $ar["pAlias"], 30 ) . "</td><td>&nbsp;" . trimString( $ar["pModel"], 30 ) . "</td><td><a href=\"?node=$_GET[node]&sub=$_GET[sub]&id=" . $id . "&dellinkid=" . $ar["paID"] . "\"><img src=\"images/deleteSmall.png\" class=\"link\" /></a></td></tr>" );
						}
					}
					else
					{
						echo ( "<tr><td colspan=\"4\" class=\"c\">"._("No printers linked to this host.")."</td></tr>" );
					}
			echo ( "</table>" );			
			
			echo ( "<div class=\"hostgroup\">" );
				echo("<p>Add new printer.</p>");
				echo ( getPrinterDropDown( $conn, "prnt" ) );
				//echo ( "<br /><br />" ); // Blackout - stop using block elements to create space!!
			echo ( "</div>" );
			
			
			echo ( "<input type=\"hidden\" name=\"update\" value=\"1\" /><input type=\"submit\" value=\""._("Update")."\" />" );
			echo ( "</form>" );
		}
	}
	else
	{
		echo ( "<center><font class=\"smaller\">"._("Invalid host ID Number.")."</font></center>" );
	}
}