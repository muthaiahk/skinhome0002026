<?php

use App\Models\UserMeta;
  
// function fileNameEncryption($filename){
//     //return $filename;
    
//     // Store a string into the variable which
//     // need to be Encrypted
//     $simple_string = $filename;

//     // Display the original string
//     // echo "Original String: " . $simple_string;

//     // Store the cipher method
//     $ciphering = "AES-128-CTR";

//     // Use OpenSSl Encryption method
//     $iv_length = openssl_cipher_iv_length($ciphering);
//     $options = 0;

//     // Non-NULL Initialization Vector for encryption
//     $encryption_iv = '1234567891011121';

//     // Store the encryption key
//     $encryption_key = "KevellsUfc";

//     // Use openssl_encrypt() function to encrypt the data
//     $encryption = openssl_encrypt($simple_string, $ciphering,$encryption_key, $options, $encryption_iv);

//     // Display the encrypted string
//     //echo "Encrypted String: " . $encryption . "\n";  
//     return $encryption;

// }
   
// function fileNameDecryption($filename)
// {
//     // Store the cipher method
//     $ciphering = "AES-128-CTR";

//     $options = 0;

//     // Non-NULL Initialization Vector for decryption
//     $decryption_iv = '1234567891011121';

//     // Store the decryption key
//     $decryption_key = "KevellsUfc";

//     // Use openssl_decrypt() function to decrypt the data
//     $decryption=openssl_decrypt ($filename, $ciphering,
//              $decryption_key, $options, $decryption_iv);

//     // Display the decrypted string
//     return $decryption;
// }

// function ufcreadfile($full_path)
// {
//     header('Content-Description: File Transfer');
//     header('Content-Type: application/octet-stream');
//     header('Content-Disposition: attachment; filename='.basename($full_path));
//     header('Content-Transfer-Encoding: binary');
//     header('Expires: 0');
//     header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//     header('Pragma: public');
//     ob_clean();
//     flush();
//     readfile($full_path);
// }

// function getmetadatas(){
//     //Create Metadata
//     $metadatas = [
//         'country',
//         'contact',
//         'language',
//         'dob',
//         'gender',
//         'address',
//         'profile_pic',
//         'hobbies',
//         'facebook_link',
//         'twitter_link',
//         'instagram_link',
//         'youtube_link',
//         'membership',
//         'height',
//         'skin_colour',
//         'personal_manager',
//         'experience',
//         'no_of_films',
//         'bio_graphy',
//         'filmo_graphy',
        
//     ];
//     return $metadatas;
// }

// function createmetadatas($user_id,$meta_key,$meta_value){
//     $metadatas_add = new UserMeta;
//     $metadatas_add->user_id    = $user_id;
//     $metadatas_add->meta_key   = $meta_key;
//     $metadatas_add->meta_value = $meta_value;
//     $metadatas_add->save();
// }

// function validateuserToken($user_id){
//     if(!$user_id){
//         return response([
//             'status'    =>  404,
//             'message'   => 'Token is incorrect',
//             'error_msg' => 'Unauthendication',
//             'data'      =>  null,
//         ]);
//     }
// }

// function validateadminToken($admin_id){
//     if(!$admin_id){
//         return response([
//             'status'    =>  404,
//             'message'   => 'Token is incorrect',
//             'error_msg' => 'Unauthendication',
//             'data'      =>  null,
//         ]);
//     }
// }

// function UserTokenCheck($token) {

//     if(!empty($token) || $token != '') {
//             $splittoken  = explode('-qeTry1-',$token);
//             $tokenKey    = fileNameDecryption($splittoken[1]);
//             $key  = explode('UniversalFansClub',$tokenKey);
//             $word = 'UniversalFansClub';
//             if(strpos($tokenKey, $word) !== false){
//                 if(!empty($splittoken[1])) {
//                     $result    =    [ 
//                                         'user_id'   => $key[1],
//                                         'user_slug' => $key[2],
//                                     ];
//                     return $result;
//                 } else {
//                     $result    =    [ 
//                         'user_id'   => 0,
//                     ];
//                     return $result;
//                 }
//             } else {
//                 $result    =    [ 
//                     'user_id'   => 0,
//                 ];
//                 return $result;
//             }
//     } else {
//         $result    =    [ 
//             'user_id'   => 'empty',
//         ];
//         return $result;
//     }
    
// }

