<?php

require_once "facebook/facebook.php";

$fb = new Facebook(array(
                'appId'  => '277019759074470',
                'secret' => 'ddcec0b3141558e73bbf4cd94dcea6dc',
                'cookie' => true
            ));

$fb_access_token = $argv[1];
$base_path = $argv[2];
$user_id = $argv[3];
$base_url = $argv[4];

$fb->setAccessToken($fb_access_token);

$user_data_folder = md5('dfgWERD3423DF3rdsfhg5345DFS3G45!' . $user_id);

$save_path = $base_path . '../application/data';

$photos = array();

if (!is_dir($save_path))
	mkdir($save_path, 0777);

get_photos('/me/photos');

function get_photos($page)
{
	global $fb, $user_id, $photos, $base_url, $save_path;
	$fb_photos = $fb->api($page);
	
	if (count($fb_photos['data']) == 0)
		return;

	foreach($fb_photos['data'] as $fb_photo)
	{
		if (isset($fb_photo['name']))
		{
			$caption = $fb_photo['name'];
			
			$tags = explode($caption, '#');
			
			//if (count($tags) > 1)
			//{
				$url = $fb_photo['source'];
				$saveto = $save_path . '/' . $fb_photo['id'] . '.jpg';
		
				if(!file_exists($saveto))
				{
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
				
					$fp = fopen($saveto,'x');
			
					fwrite($fp, $raw);
					fclose($fp);
				}
				
				foreach($tags as $tag)
				{
					////set POST variables
					$url = $base_url . 'insert_items';
					$fields = array(
								 "photo_id" => urlencode($fb_photo['id']),
								 "tag" => urlencode($tag)
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
					curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_DIGEST);
				
					//execute post
					$result = curl_exec($ch);
				
					//close connection
					curl_close($ch);
				}
			//}
		}
	}
	
	if (isset($fb_photos['paging']))
	{
		//if (isset($fb_photos['paging']['next']))
//		{
//			$until_pos = strpos($fb_photos['paging']['next'], 'until');
//			if ($until_pos)
//				$until = substr($fb_photos['paging']['next'], $until_pos);
//			else
//				return;
//			get_photos('/me/photos?limit=25&' . $until);
//		}
	}
	else
		return;
}