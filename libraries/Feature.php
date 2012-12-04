<?php
/**
 * The feature release system
 * We can release "features" to users and only enable it to be show to certain users.
 * 
 * @version    0.4
 * @author     srtfisher
 * @license    GPL
**/
class Feature
{
	/**
	 * The current user ID
	 *
	 * @access public
	 * @global int
	**/
	public static $current_user = FALSE;
	
	/**
	 * The constructor
	 *
	 * @access public
	**/
	public static function init()
	{
		get_instance()->load->config('features');
	}
	
	/**
	 *	Set the active user ID to work with.
	 *
	 *	@param $ID int The user's ID
	**/
	public static function setUser( $ID = FALSE )
	{	
		if (! $ID)
		   return;
          
          $ID = (int) $ID;
		self::$current_user = $ID;
	}
	
	/**
	 * The main function to see if a use can perform an actual feature.
	 *
	 * @param string The name of the feature
	 * @return bool
	**/
	public static function can( $feature )
	{
		$array = config_item('features');
		
		// Is it in an invalid format?
		if ( ! is_array( $array ) )
			return FALSE;
          
          // Are they logged in?
          if ( is_null(self::$current_user) AND ! is_bool( self::$current_user ) OR self::$current_user < 1)
               return FALSE;
          
		// Loop though each feature
		foreach($array as $name => $row) {
			if ($name == $feature) :
				if ($row['restrict_type'] == 'general') {
					// It's a general on/off switch.
					if ($row['status'] !== 'on')
						return FALSE;
					else
						return TRUE;
				} elseif ($row['restrict_type'] == 'user_specific') {
					// It's a user bucket.
					// Why try!
					if ( ! self::$current_user )
						return FALSE;
					// var_dump( $name, $row );
		
					// It's a userspecific one
					if ($row['search_variable'] !== '=' AND $row['search_variable'] !== '>' AND $row['search_variable'] !== '>='
					     AND $row['search_variable'] !== '<' AND $row['search_variable'] !== '<==' AND $row['search_variable'] !== '!==')
						return FALSE;	// Validate search terms.
					
					// What type of select users.
					switch($row['search_variable'])
					{
						case '>' :
							if (is_array($row['search_term']))
								return FALSE;	// String only!
							
							if (self::$current_user > $row['search_term'])
								return TRUE;
							else;
								return TRUE;
						break;
						
						case '>=' :
							if (is_array($row['search_term']))
								return FALSE;	// String only!
							
							if (self::$current_user >= $row['search_term'])
								return TRUE;
							else;
								return TRUE;
						break;
						
						case '<' :
							if (is_array($row['search_term']))
								return FALSE;	// String only!
							
							if (self::$current_user <= $row['search_term'])
								return TRUE;
							else;
								return TRUE;
						break;
						
						case '<=' :
							if (is_array($row['search_term']))
								return FALSE;	// String only!
							
							if (self::$current_user <= $row['search_term'])
								return TRUE;
							else;
								return TRUE;
						break;
						
						case '!=' :
							if (is_array($row['search_term'])) :
								// Loop through an array.
								foreach($row['search_term'] as $rua)
								{
									if (self::$current_user == $rua)
										return FALSE;
								}
								return TRUE;
							else :
							if (self::$current_user != $row['search_term'])
								return TRUE;
							else;
								return TRUE;
							
							endif;
						break;
						
						// Defaults to "="
						default;
							if (is_array($row['search_term'])) {
								if (in_array(self::$current_user, $row['search_term']))
									return TRUE;
								else
									return FALSE;
							} else {
								if ($row['search_term'] == self::$current_user)
									return TRUE;
								else
									return FALSE;
							}
							break;
					}
				} else {
					// We haven't created this type yet
					return FALSE;
				}
			endif;
		}
		return FALSE;
	}
}

/**
 * Helper function to see if a user can do a feature
 *
 * @access public
 * @return bool
 * @see Feature::can()
**/
function can_do_feature($which)
{
	return Feature::can($which);
}

/* End of file */