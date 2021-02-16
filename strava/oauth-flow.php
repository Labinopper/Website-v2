<?php

    require '../../db_connection.php';
    include("../auth_session.php");

// Use Composer's autoloader or include the StravaApi class manually:
//require_once './vendor/autoload.php';
    require_once 'StravaApi.php';

// Replace with the actual URL of this file:
    define('CALLBACK_URL', 'http://labinopper.000webhostapp.com/strava/oauth-flow.php?action=callback');
// Insert your Strava App ID + Secret:
    define('STRAVA_API_ID', '61720');
    define('STRAVA_API_SECRET', '11aeefa6ca2165b893c14c6be3392f699d3cfd6b');

// We save access and refresh tokens as well as the expire timestamp in the session.
// So we've to enable session support:
// session_start();

// Instatiate the StravaApi class with API ID and API Secret (replace placeholders!):
$api = new Iamstuartwilson\StravaApi(STRAVA_API_ID, STRAVA_API_SECRET);

// Setup the API instance with authentication tokens, if possible:
if (
    !empty($_SESSION['strava_access_token'])
    && !empty($_SESSION['strava_refresh_token'])
    && !empty($_SESSION['strava_access_token_expires_at'])
) {
    $api->setAccessToken(
        $_SESSION['strava_access_token'],
        $_SESSION['strava_refresh_token'],
        $_SESSION['strava_access_token_expires_at']
    );
}

$action = isset($_GET['action']) ? $_GET['action'] : 'default';

switch ($action) {
    case 'auth':
        header('Location: ' . $api->authenticationUrl(CALLBACK_URL, 'auto', 'read_all,activity:read'));

        return;

    case 'callback':
        echo '<h2>Callback Response Data</h2>';
        echo '<pre>';
        print_r($_GET);
        echo '</pre>';
        $code = $_GET['code'];
        $response = $api->tokenExchange($code);
        echo '<h2>Token Exchange Response Data</h2>';
        echo '<p>(after swapping the code from callback against tokens)</p>';
        echo '<pre>';
        print_r($response);
        echo '</pre>';

        $_SESSION['strava_access_token'] = isset($response->access_token) ? $response->access_token : null;
        $_SESSION['strava_refresh_token'] = isset($response->refresh_token) ? $response->refresh_token : null;
        $_SESSION['strava_access_token_expires_at'] = isset($response->expires_at) ? $response->expires_at : null;

        echo '<h2>Session Contents (after)</h2>';
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';

        echo '<p><a href="?action=test_request">Send test request</a></p>';
        echo '<p><a href="?action=refresh_token">Refresh Access Token</a></p>';

        //Add to DB
        $sat = $_SESSION['strava_access_token'];
        $srf = $_SESSION['strava_refresh_token'];
        $satea = $_SESSION['strava_access_token_expires_at'];
        $user = $_SESSION['username'];
        $store = "UPDATE `Users` SET 
                        `strava_access_token` = '$sat',
                        `strava_refresh_token` = '$srf',
                        `strava_access_token_expires_at` = '$satea'
                    WHERE
                        `username` = '$user'";
        $store2 = mysqli_query($conn, $store);

        return;

    case 'testnew':
        echo '<h2>Session Contents</h2>';
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';

        $response = $api->get('/athlete/activities');
        echo '<h2>Test Request (/athlete/activities)</h2>';
        echo '<pre>';
        print_r($response);
        echo '</pre>';

        return;   

    case 'refresh_token':
        echo '<h2>Session Contents (before)</h2>';
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';

        echo '<h2>Refresh Token</h2>';
        $response = $api->tokenExchangeRefresh();
        echo '<pre>';
        print_r($response);
        echo '</pre>';

        $_SESSION['strava_access_token'] = isset($response->access_token) ? $response->access_token : null;
        $_SESSION['strava_refresh_token'] = isset($response->refresh_token) ? $response->refresh_token : null;
        $_SESSION['strava_access_token_expires_at'] = isset($response->expires_at) ? $response->expires_at : null;

        echo '<h2>Session Contents (after)</h2>';
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';

        //Add to DB
        $sat = $_SESSION['strava_access_token'];
        $srf = $_SESSION['strava_refresh_token'];
        $satea = $_SESSION['strava_access_token_expires_at'];
        $user = $_SESSION['username'];
        $store = "UPDATE `Users` SET 
                        `strava_access_token` = '$sat',
                        `strava_refresh_token` = '$srf',
                        `strava_access_token_expires_at` = '$satea'
                    WHERE
                        `username` = '$user'";
        $store2 = mysqli_query($conn, $store);

        return;

    case 'test_request':
        echo '<h2>Session Contents</h2>';
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';

        /*
        //User Details
        $response = $api->get('/athlete');
        echo '<h2>Test Request (/athlete)</h2>';
        echo '<pre>';
        print_r($response);
        echo '</pre>';
        */
        
        //Activity List
        $page = '1';
        $response = $api->get('/athlete/activities?page=1&per_page=100');
        echo '<h2>Test Request (/athlete/activities?page=1&per_page=100)</h2>';
        echo '<pre>';
        print_r($response[0]);
        echo '</pre>';
        foreach ($response as $r) {
            $user_id = $_SESSION['id'];
            $activity_id = $r->id;
            $activity_name = $r->name;
            $moving_time = $r->moving_time;
            $elapsed_time = $r->elapsed_time;
            $elevation = $r->total_elevation_gain;
            $type = $r->type;
            $start_date_time = $r->start_date_local;
            
            $start_date = explode('T',$start_date_time,2);
            print_r($start_date[0]);
            print "<br>";
            $start_time = explode('Z',$start_date[1],-1);
            print_r($start_time[0]);
            
            $distance = $r->distance;
            
            $achievement_count = $r->achievement_count;
            if(isset($r->average_watts)) {
                $average_watts = $r->average_watts;
            }
            else{$average_watts = '0';}
            if(isset($r->max_watts)) {
                $max_watts = $r->max_watts;
            }
            else{$max_watts = '0';}
            if(isset($r->average_heartrate)) {
                $average_heartrate = $r->average_heartrate;
            }
            else{$average_heartrate = '0';}
            if(isset($r->max_heartrate)) {
                $max_heartrate = $r->max_heartrate;
            }
            else{$max_heartrate = '0';}
            $average_speed = $r->average_speed;
            $max_speed = $r->max_speed;
            if(isset($r->average_cadence)) {
                $average_cadence = $r->average_cadence;
            }
            else{$average_cadence = '0';}
            echo '<br>$user_id: ';
            echo $user_id;
            echo '<br>$activity_id: ';
            echo $activity_id;
            echo '<br>$activity_name: ';
            echo $activity_name;
            echo '<br>$moving_time: ';
            echo $moving_time;
            echo '<br>$elapsed_time: ';
            echo $elapsed_time;
            echo '<br>$elevation: ';
            echo $elevation;
            echo '<br>$type: ';
            echo $type;
            echo '<br>$start_date_time: ';
            echo $start_date_time;
            echo '<br>$achievement_count: ';
            echo $achievement_count;
            if(isset($r->average_watts)) {
                echo '<br>$average_watts: ';
                echo $average_watts;
            }
            if(isset($r->max_watts)) {
                echo '<br>$max_watts: ';
                echo $max_watts;
            }
            if(isset($r->average_heartrate)) {
                echo '<br>$average_heartrate: ';
                echo $average_heartrate;
            }
            if(isset($r->max_heartrate)) {
                echo '<br>$max_heartrate: ';
                echo $max_heartrate;
            }
            echo '<br>$average_speed: ';
            echo $average_speed;
            echo '<br>$max_speed: ';
            echo $max_speed;
            if(isset($r->average_cadence)) {
                echo '<br>$average_cadence: ';
                echo $average_cadence;
            }
            echo '<br><br>';
            
            $query    = "SELECT * FROM `Activities` WHERE activity_id ='$activity_id'";
            $result = mysqli_query($conn, $query) or die(mysql_error());
            $rows = mysqli_num_rows($result);
            if ($rows == 0) {
                $queryinsert = "INSERT INTO `Activities`(
                                    `user_id`,
                                    `activity_id`,
                                    `activity_name`,
                                    `moving_time`,
                                    `elapsed_time`,
                                    `elevation`,
                                    `type`,
                                    `start_date`,
                                    `start_time`,
                                    `achievement_count`,
                                    `average_watts`,
                                    `max_watts`,
                                    `average_heartrate`,
                                    `max_heartrate`,
                                    `average_speed`,
                                    `max_speed`,
                                    `average_cadence`,
                                    `distance`
                                )
                                VALUES('$user_id','$activity_id','$activity_name','$moving_time','$elapsed_time','$elevation','$type','$start_date[0]','$start_time[0]','$achievement_count','$average_watts','$max_watts','$average_heartrate','$max_heartrate','$average_speed','$max_speed','$average_cadence','$distance')";
                $resultinsert = mysqli_query($conn,$queryinsert);
                echo $queryinsert;
                echo '<br>';
            }
        }
        
        /*
        foreach ($response as $r) {
          print_r($r->name);
        }
        */
        
        /*
        //Activity Breakdown
        $response = $api->get('/activities/4756653197?include_all_efforts=true');
        echo '<h2>Test Request (/activities/4756653197?include_all_efforts=true)</h2>';
        echo '<pre>';
        print_r($response);
        echo '</pre>';
        
        //Activity Stream
        $response = $api->get('/activities/4756653197/streams?keys=distance,time&key_by_type=true');
        echo '<h2>Test Request (/activities/4756653197/streams?keys=distance,time&key_by_type=true)</h2>';
        echo '<pre>';
        print_r($response);
        echo '</pre>';


        */
        return;

    case 'default':
    default:
        echo '<p>Start authentication flow.</p>';
        echo '<p><a href="?action=auth">Start oAuth Authentication Flow</a> (Strava oAuth URL: <code>'
            . $api->authenticationUrl(CALLBACK_URL)
            . '</code>)</p>';
        echo '<h2>Session Contents</h2>';
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
        echo '<p><a href="?action=refresh_token">Refresh Access Token</a></p>';
        echo '<p><a href="?action=testnew">TEST</a></p>';
}
