<?php
	
if ( IS_INCLUDED !== true ) die( _("Unable to load system configuration information.") );

if ( $currentUser != null && $currentUser->isLoggedIn() )
{
	if ( $_GET[sub] == "add" )
	{
		require_once( "./includes/printer.add.include.php" );
	}
	else if ( $_GET[sub] == "list" )
	{
		require_once( "./includes/printer.list.include.php" );
	}	
	else if ( $_GET[sub] == "edit" )
	{
		require_once( "./includes/printer.edit.include.php" );
	}
	else if ( $_GET[sub] == "delete" )
	{
		require_once( "./includes/printer.delete.include.php" );
	}	
	else if ( $_GET[sub] == "search" )
	{
		require_once( "./includes/printer.search.include.php" );
	}												
	else
	{
		if ( getSetting( $conn, "FOG_VIEW_DEFAULT_SCREEN" ) == "LIST" )
			require_once( "./includes/printer.list.include.php" );
		else
			require_once( "./includes/printer.search.include.php" );
	}
}
?>
