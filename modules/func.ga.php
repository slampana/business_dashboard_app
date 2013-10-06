<?php

function getRefreshToken($username, $refresh_token)
{
    if (empty($refresh_token)):
        echo "No Google Analytics refresh token was given.";
    else:
        global $coll;
        $coll->update(array('username' => $username),
            array('$set' => array('ga_refresh_token' => $refresh_token)
            ));
        return true;
    endif;
}

function getWebProperty($username, $ga_property_id, $ga_property_name)
{
    if (empty($ga_property_id)):
        echo "No Google Analytics web property ID was given.";
    else:
        global $coll;
        $coll->update(array('username' => $username),
            array('$push' => array('ga_web_property' => array('ga_property_id' => $ga_property_id, 'ga_property_name' => $ga_property_name)
            )));
        return true;
    endif;
}

?>