SQL database is in storage/schemas
Code is populated with TODO comments 

Current errors:
	Cant access DI: Getting unchaught error: Access to undeclared static property: Phalcon\Di::$_default
			When posting a curl request in HouseController.php; don't get the error when I use curl via the terminal

	User login findfirst always returns true
			When checking for email/password combinations

	jsongetrawbody doesnt retrieve json object from curl POST
			The array is posted as json array (tried with and without application/json header) but the server retrieves it as a string

	INNER JOIN query doesnt return results
		The query works in phpmyadmin but does not return anything when executed with Phalcon

More TODO:
	Generating a key (UUID without the "-"?) and link that to the user in the database. Then only allow the server to process requests if the user_id and key are matching.
	Admin users are an exception

	Make a api that can filter on types of rooms and amount of rooms (e.g. toilets)