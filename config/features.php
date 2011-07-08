<?php
/**
 * Features Flags
 *
 * This is a feature that will let us enable or disable features for specific users.
 * Usefull in testing new features or addons, or disabling some due to issues.
 *
 * @author talkingwithsean <http://talkingwithsean.com>
 * @version 0.8
**/


//	These will enable or disable a feature.
//	Use a bool to set the value to.

//	You can create a new feature and setup a multude of data for it
//	'restrict_type'	=>	(user_specific for a specific array of user, or general for a general on/off switch

$config['did_load_feature']	=	true;
$config['features']	=	array(
	//	We want to control features, even though everybody can access them initially.
	//	If we have the functions setup to disable them with one line,
	//	it's much easier than with multiple lines.
	
	/**
	We store features like this
	
	<code>
	'feature_name'		=>	array(
						//	How are we restricting them?
						'restrict_type'	=>	'general',	//	General on/off switch
						'restrict_type'		=>	'user_specific',	//	User specific switch
						
						//	If it's a general switch, we can turn it off/on here
						'status'	=>	'on',
						
						//	If it's a user specific search, how are we searching for users?
						
						//	A user's ID is in an array OR the current user ID is equal to a specific user's ID
						'search_variable'	=>	'=',
						
						//	We can also accept other things, such as:
						//	>, <, <==, and >==
						//	When you use these, the search term can only be a string. 
						//	See php.net to see what these search terms mean.
						
						//	This is the search term.
						//	Depening upon what your search_variable is, this will be an array or string
						'search_term'	=>	array(1, 9),
						'search_term'	=>	200,
		),
	</code>					
	**/
	'forums'		=>	array(
						'restrict_type'	=>	'general',
						'status'	=>	'on',
						
						'search_variable'	=>	'=',
						'search_term'	=>	array(1, 29),
	)
	,
);
/* End of file */