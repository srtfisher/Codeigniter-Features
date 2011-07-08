<?php
/**
 * Helper function to see if a user can do a feature
 *
 * @access public
 * @return bool
 * @see Feature::can()
**/
function can_do_feature($which)
{
	return get_instance()->feature->can($which);
}

/* End of file feature_helper.php */