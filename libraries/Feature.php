<?php
/**
 * The feature release system
 * We can release "features" to users and only enable it to be show to certain users.
 * 
 * @version 0.2
 * @author talkingwithsean
 * @license GPL
**/
class Feature
{
	/**
	 * The current user ID
	 *
	 * @access public
	 * @global int
	**/
	public $current_user = FALSE;
	
	/**
	 * The constructor
	 *
	 * @access public
	**/
	public function __construct()
	{
		get_instance()->load->config('features');
	}
	
	/**
	 *	Set the active user ID to work with.
	 *
	 *	@param int The user's ID
	**/
	function set_user( $ID = FALSE )
	{
		$ID = (int) $ID;
		$this->current_user = $ID;
	}
	
	/**
	 * The main function to see if a use can perform an actual feature.
	 *
	 * @param string The name of the feature
	 * @return bool
	**/
	function can( $feature )
	{
		$array = config_item('features');
		
		//	Is it in an invalid format?
		if ( ! is_array( $array ) )
			return FALSE;
			
		//	Loop though each feature
		foreach($array as $name => $row) {
			if ($name == $feature) :
				if ($row['restrict_type'] == 'general') {
					//	It's a general on/off switch.
					if ($row['status'] !== 'on')
						return FALSE;
					else
						return TRUE;
				} elseif ($row['restrict_type'] == 'user_specific') {
					//	It's a user bucket.
					//	Why try!
					if ( ! $this->current_user )
						return FALSE;
					//	var_dump( $name, $row );
		
					//	It's a userspecific one
					if ($row['search_variable'] !== '=' && $row['search_variable'] !== '>' && $row['search_variable'] !== '>=' && $row['search_variable'] !== '<' && $row['search_variable'] !== '<==' && $row['search_variable'] !== '!==')
						return FALSE;	//	Validate search terms.
					
					//	What type of select users.
					switch($row['search_variable'])
					{
						case('>');
							if (is_array($row['search_term']))
								return FALSE;	//	String only!
							
							if ($this->current_user > $row['search_term'])
								return TRUE;
							else;
								return TRUE;
						break;
						
						case('>=');
							if (is_array($row['search_term']))
								return FALSE;	//	String only!
							
							if ($this->current_user >= $row['search_term'])
								return TRUE;
							else;
								return TRUE;
						break;
						
						case('<');
							if (is_array($row['search_term']))
								return FALSE;	//	String only!
							
							if ($this->current_user <= $row['search_term'])
								return TRUE;
							else;
								return TRUE;
						break;
						
						case('<=');
							if (is_array($row['search_term']))
								return FALSE;	//	String only!
							
							if ($this->current_user <= $row['search_term'])
								return TRUE;
							else;
								return TRUE;
						break;
						
						case('!=');
							if (is_array($row['search_term'])) :
								//	Loop through an array.
								foreach($row['search_term'] as $rua)
								{
									if ($this->current_user == $rua)
										return FALSE;
								}
								return TRUE;
							else :
							if ($this->current_user != $row['search_term'])
								return TRUE;
							else;
								return TRUE;
							
							endif;
						break;
						
						//	Defaults to "="
						default;
							if (is_array($row['search_term'])) {
								if (in_array($this->current_user, $row['search_term']))
									return TRUE;
								else
									return FALSE;
							} else {
								if ($row['search_term'] == $this->current_user)
									return TRUE;
								else
									return FALSE;
							}
							break;
					}
				} else {
					//	We haven't created this type yet
					return FALSE;
				}
			endif;
		}
		return FALSE;
	}
}

/* End of file feature.php */