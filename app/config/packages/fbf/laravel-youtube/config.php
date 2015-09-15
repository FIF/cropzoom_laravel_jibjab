<?php

return array(

	/**
	 * Application name
	 */
	'application_name' => 'My App',

	/**
	 * Client ID
	 */
	'client_id' => '396843889331-u79mj729dao4dqi2tio1ej8pgfs0t2io.apps.googleusercontent.com', //local
//	'client_id' => '396843889331-effnqot0u1tttqvs32j8c9bumcqme15o.apps.googleusercontent.com', // server

	/**
	 * Client Secret
	 */
	'client_secret' => '8zLzp0vUqWjF1TvQX6BqHqnn', //local
//	'client_secret' => '0JjRpE5B-x2kihNJRec86uc0', //server

	/**
	 * Redirect URI. This should be just the path part of the URI, excluding the http://mydomain.com/ part
	 */
	'redirect_uri' => 'youtube/oauth2callback',

	/**
	 * Scopes
	 */
	'scopes' => array('https://www.googleapis.com/auth/youtube.upload', 'https://www.googleapis.com/auth/youtube.readonly'),

	/**
	 * Access type
	 */
	'access_type' => 'offline',

	/**
	 * Approval prompt
	 */
	'approval_prompt' => 'auto',

	/**
	 * Table name for Accestokens 
	 */
	'table_name' => 'fbf_youtube_access_token',

	/** 
	 * Save and access the authentication tokens based on the Authenticated user. 
	 * Preferable when your system makes use of multiple users with Laravels authentication
	 */
	'auth' => false,

);