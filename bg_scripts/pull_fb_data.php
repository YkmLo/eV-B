<?php

require_once "facebook/facebook.php";

$fb = new Facebook(array(
                'appId'  => '277019759074470',
                'secret' => 'ddcec0b3141558e73bbf4cd94dcea6dc',
                'cookie' => true
            ));

$user_id = $argv[1];
$couple_fb_id = $argv[2];
$couple_id = $argv[3];
$fb_access_token = $argv[4];

$fb->setAccessToken($fb_access_token);

$user_data_folder = md5('MNQWRFVPOIUYTREWQALSKDJFHG!' . $user_id);
$basedir = '/var/www/Lopidopi_data/';
$save_path = $basedir . $user_data_folder;

$photos = array();

if (!is_dir($save_path))
	mkdir($save_path, 0777);

get_photos('/me/photos');

process_array();

function get_photos($page)
{
	global $fb, $couple_fb_id, $user_id, $couple_id, $photos;
	$fb_photos = $fb->api($page);
	
	if (count($fb_photos['data']) == 0)
		return;

	foreach($fb_photos['data'] as $fb_photo)
	{
		$flag_tag = false;
		foreach($fb_photo['tags']['data'] as $tagged)
		{
			if(isset($tagged['id']) && $tagged['id'] == $couple_fb_id)
			{
				$flag_tag = true;
				break;
			}
		}
		if($flag_tag == true)
		    $photos[] = $fb_photo;
	}
	
	if (isset($fb_photos['paging']))
	{
		if (isset($fb_photos['paging']['next']))
		{
			$until_pos = strpos($fb_photos['paging']['next'], 'until');
			if ($until_pos)
				$until = substr($fb_photos['paging']['next'], $until_pos);
			else
				return;
			get_photos('/me/photos?limit=25&' . $until);
		}
	}
	else
		return;
}

function process_array()
{
    global $save_path, $user_id, $couple_id, $photos;
    foreach (array_reverse($photos, true) as $fb_photo)
    {
        $url = $fb_photo['source'];
	    $saveto = $save_path . '/moment_' . (microtime(true) * 10000) . '.jpg';

	    $ch = curl_init ($url);

	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	    curl_setopt($ch, CURLOPT_SSLVERSION, 3);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	    /** ignore ssl verification */
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	    /** end of ignore ssl verification */

	    $raw=curl_exec($ch);
	    curl_close ($ch);

	    if(file_exists($saveto))
		    unlink($saveto);
	
	    $fp = fopen($saveto,'x');

	    fwrite($fp, $raw);
	    fclose($fp);
	
	    create_moment($couple_id, $user_id, $saveto);
	}
}

function create_moment($couple_id, $initiator_id, $save_path)
{
	//set POST variables
	$url = 'http://api.lopidopi.dev:8080/api/moments/create';
	$fields = array(
		         "couple_id" => urlencode($couple_id),
					"photo_directory" => urlencode($save_path),
					"initiator_id" => urlencode($initiator_id),
					"privacy" => urlencode('public'),
					"type" => urlencode('single_photo')
		     );
		     
	$fields_string = '';

	//url-ify the data for the POST
	foreach($fields as $key=>$value)
	{
		$fields_string .= $key.'='.$value.'&';
	}
	
	rtrim($fields_string, '&');

	//open connection
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_POST,count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
	curl_setopt($ch,CURLOPT_USERPWD,'web:web');
	curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_DIGEST);

	//execute post
	$result = curl_exec($ch);

	//close connection
	curl_close($ch);
}

?>
