<?php

include_once('modules/config.php');

if(!loggedIn()):
    echo '<script> window.location="login.php"; </script> ';
else:
    $query = $coll->findOne(array('username' => $_SESSION["username"]));
    $refresh_token = $query['ga_refresh_token'];
    $result_properties = [];

    if (!isset($query['ga_refresh_token'])):
        echo '<script> window.location="' . $get_ga_code_url . '"; </script> ';
    else:
        $access_token = getAccessToken($refresh_token);

        //Get visitors for last 30 days
        if(isset($access_token)):
            foreach ($query['ga_web_property'] as $obj_property):
                $selected_profile = $obj_property['ga_property_id'];
                $total_visitors = 0;
                $total_new_visits = 0;

                $result_visitors = getVisitsMonth($access_token, $selected_profile);

                echo "Property: " . $obj_property['ga_property_name'] . '<br/>';
                foreach ($result_visitors['rows'] as $item):
                    $item['date'] = $item[0];
                    unset($item[0]);

                    $item['visitors'] = $item[1];
                    unset($item[1]);

                    $item['new_visits'] = $item[2];
                    unset($item[2]);

                    $total_visitors += $item['visitors'];
                    $total_new_visits += $item['new_visits'];

                    echo $item['date'].'---'.$item['visitors'].'---'.$item['new_visits']."<br>";
                endforeach;

                echo "Total Visitors---".$total_visitors."<br>";
                echo "Total New Visits---".$total_new_visits."<br>";

                $result_sources = getSourcesMonth($access_token, $selected_profile);

                echo "Property: " . $obj_property['ga_property_name'] . '<br/>';
                foreach ($result_sources['rows'] as $item):
                    $item['source'] = $item[0];
                    unset($item[0]);

                    $item['visitors'] = $item[1];
                    unset($item[1]);

                    echo $item['source'].'---'.$item['visitors']."<br>";
                endforeach;
            endforeach;
        else:
            echo "No Google Analytics access token was found.";
        endif;
    endif;
endif;

?>