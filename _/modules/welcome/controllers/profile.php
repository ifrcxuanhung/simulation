<?php
//require('_/modules/welcome/controllers/block.php');
require('_/modules/welcome/controllers/class.phpmailer.php');
require('_/modules/welcome/controllers/class.smtp.php');
require('_/modules/welcome/controllers/class.pop3.php');
class Profile extends Welcome{
    public function __construct() {
        parent::__construct();
		 $this->load->model('Profile_model', 'user');
		  $this->load->model('Tab_model', 'tab');
		 $this->load->model('dashboard_model','dashboard');
    }
    
    public function index() {
    
		if(!isset($this->session->userdata['user_id'])){
			$url = explode("profile",$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			$baseURL = $url[0];
			header("location:http://$baseURL");
			exit;
		}
		
		$detail_user = $this->user->get_detail_user_new($this->session->userdata('user_id'));
		$this->data->level_user = unserialize($detail_user[0]['user_level']);
		//echo "<pre>";print_r($this->data->level_user);exit;
		foreach($detail_user as $k=>$dupma){
			$dupme['info'] = $dupma;
			$dupme[$dupma['label']] = $dupma['profile_value'];	
		}
		$this->data->detail_user = $dupme;
		
		$sql = "select sql_calc_found_rows vcr.format, str_id,datetime,A.dsymbol, order_type,`b/s`, type_order,type,strike, expiry, price, quantity, id_user,`status`
                from (select concat(id,'_','options')as str_id, datetime,dsymbol,order_type,`b/s`, 'Options' as type_order, type, strike, expiry, price, quantity,id_user,`status` from vdm_order_options_daily union all (select concat(id,'_','futures')as str_id, datetime,dsymbol,order_type,`b/s`,'Futures' as type_order, 0 as type, 0 as strike, expiry, price, quantity,id_user,`status`  from vdm_order_futures_daily)) as A LEFT JOIN vdm_contracts_ref vcr 
ON vcr.dsymbol = A.dsymbol where id_user='".$_SESSION['simulation']['user_id']."' ORDER BY datetime desc";
		$this->data->orders = $this->db3->query($sql)->result_array();
		
		$sql_2 = "select sql_calc_found_rows sTable.`id`, sTable.`dsymbol`, sTable.`datetime`, sTable.`type`, sTable.`expiry`, sTable.`p`, sTable.`q`, vcr.format
                from (SELECT * FROM excution_traded WHERE user_buy = '".$_SESSION['simulation']['user_id']."'or user_sell = '".$_SESSION['simulation']['user_id']."') 
				as sTable LEFT JOIN vdm_contracts_ref vcr 
					ON vcr.dsymbol = sTable.dsymbol
				 order by sTable.datetime desc ";
		$this->data->trades = $this->db3->query($sql_2)->result_array();
		//echo "<pre>";print_r($this->data->trades);exit;
		
		
        $this->template->write_view('content', 'profile/index', $this->data);
        $this->template->render();
    }
	
	
	public function sendmail($mailto, $nameto, $namefrom, $subject, $noidung, $namereplay, $emailreplay)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP(); // set mailer to use SMTP
        $mail->Host = "mail.ifrc.vn"; // specify main and backup server
        $mail->Port = 465; // set the port to use
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->SMTPSecure = "ssl";
        $mail->Username = "news@upmd.fr"; // your SMTP username or your gmail username// Email gui thu
        $mail->Password = "DmPuswen"; // your SMTP password or your gmail password
        //$from = $mailfrom; // Reply to this email// Email khi reply
        $mail->CharSet = "utf-8";
        $from = $emailreplay; // Reply to this email// Email khi reply
        $to = $mailto; // Recipients email ID // Email nguoi nhan
        $name = $nameto; // Recipient's name // Ten cua nguoi nhan
        $mail->From = $from;
        $mail->FromName = $namefrom; // Name to indicate where the email came from when the recepient received// Ten nguoi gui
        $mail->AddAddress($to, $name);
        $mail->AddReplyTo($from, $namereplay); // Ten trong tieu de khi tra loi
        $mail->WordWrap = 50; // set word wrap
        $mail->IsHTML(true); // send as HTML
        $mail->Subject = $subject;
        $mail->Body = $noidung; //HTML Body
        $mail->AltBody = ""; //Text Body

        if (!$mail->Send())
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
	
	public function uploadCSV(){
		if(isset($_REQUEST['upload_file'])){
			$filename = $_FILES['upload']['tmp_name'];
			
			
			 if (is_uploaded_file($filename)) {
					$fd = fopen($filename, "r");
					$csv_data = array();
					
					while ($row = fgetcsv($fd)) {
						$csv_data[] = $row;
					}
					// cut array profile
					foreach($csv_data as $val_profile){
						$array_profile[] = array_slice($val_profile,4);	
					}
					//echo "<pre>";print_r($array_profile);exit;
					// remove first row, it should be the headers
					$csv_headers = array_shift($csv_data);
					// pull out the defaults, first name, last name, emails
					
					$import_count = 0;
					
					set_time_limit(0);
					ini_set('memory_limit', -1);
					
					foreach ($csv_data as $k=>$data) {
						if (!trim($data[0]))
							continue;
						//$data = explode(chr(9), $data[0]);
						
						$email_username[] = array(trim($data[0]),trim($data[2]),trim($data[3]));
						$fields_user = array(
							"user_level"=> 'a:1:{i:0;s:1:"3";}',
							"username" => trim($data[0]),
							"name" => trim($data[1]),
							"email" => trim($data[2]),
							"password" => md5(trim($data[3]))
						);
						
						if ($data[2] != '' && !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $data[2])) {
							echo "Have email error!";
							return false;
						}
						elseif($this->checkusername($data[0]) == false){
							echo "Have username exists!";
							return false;	
						}
						else{
							// insert to table login_users
							$this->db->insert("login_users",$fields_user);
							
							$import_count++;
						}
						
					}
					
					
					// handle give login_profile_fields
					$count_user = count($array_profile)-1;
					$user_id = $this->db->query("SELECT user_id,username FROM login_users ORDER BY user_id DESC LIMIT 0,$count_user")->result_array();
					$user_id_reverse = array_reverse($user_id);
					foreach($array_profile as $key=>$val_p1){
						if($key == 0) continue;
						foreach($val_p1 as $key2 =>$val_p2){
							$label = $array_profile[0][$key2];
							$id_lpf = $this->db->query("SELECT id FROM login_profile_fields WHERE label = '$label'")->row_array();
							$field_profile[$key][$id_lpf['id']] = array('pfield_id'=>$id_lpf['id'],'user_id'=>$user_id_reverse[$key-1]['user_id'],'profile_value'=>$array_profile[$key][$key2]);
						}
						
						// INSERT data to vdm_user_summary
						$id_user = $user_id_reverse[$key-1]['user_id'];
						$username = $user_id_reverse[$key-1]['username'];
						
						$this->db3->query("INSERT INTO `vdm_user_summary` (`id_user`,`user_name`,`initial`,`cur_value`,`perform`,`opt_nb_ord`,`opt_nb_trd`,`opt_volume`,`fut_nb_ord`,`fut_nb_trd`,`fut_volume`,`tt_nb_ord`,`tt_nb_trd`,`tt_volume`)
			VALUES ($id_user,'$username',10000000,10000000,0,0,0,0,0,0,0,0,0,0);");
						//End INSERT data to vdm_user_summary
						
					}
					//$cut_field_profile = array_shift($field_profile);
					
					//echo "<pre>";print_r($field_profile);
					//insert to table login_profiles
					foreach($field_profile as $data_field_profile){
						foreach($data_field_profile as $d_f_p){
							$this->db->insert("login_profiles",$d_f_p);	
						}
					}
					
					// send emails to active
					//echo "<pre>";print_r($email_username);exit;
					foreach($email_username as $e_u){
						$username = $e_u[0];
						$email = $e_u[1];
						$pass = $e_u[2];
						$key = md5(uniqid(mt_rand(),true));
						$this->db->query("INSERT INTO `login_confirm` (`username`, `key`, `email`, `type`)
								VALUES ('$username', '$key', '$email', 'new_user');");	
								
						$name = $username;
						$email = $email;
						$message = "Hello $name !<br>
									Thanks for registering at ".base_url().". Here are your account details:<br>
									Username: $name <br>
									Email: $email <br>
									Password: $pass <br>
									You will first have to activate your account by clicking on the following link:<br>
									".base_url()."user-manage/activate.php?key=$key";
		
						$to = $email;
						$subject = "Email contact of {$name} ({$email})";
						$message = $message;
						$send = $this->sendmail($to, $to, $name, $subject, $message, $to, $to);
						
						
					}
					
				
					echo "Successfully imported $import_count members. Lets hope it worked! <a href='".base_url()."'>click here</a> to find out!";
					exit;
				}
		}	
	}
    function checkusername($username){
		$count = $this->db->query("SELECT * FROM login_users  WHERE username = '$username'")->num_rows();
		 if($count==0)
		   return true;
		else
			return false;
	}
   
    function upload_image() {
        
        $allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPG", "JPEG", "PNG");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);

        $respone['error'] = '';
        $respone['success'] = '';
        
        if ($_FILES["file"]["type"] == "image/gif"
        	|| $_FILES["file"]["type"] == "image/jpeg"
        	|| $_FILES["file"]["type"] == "image/jpg"
	        || $_FILES["file"]["type"] == "image/pjpeg"
	        || $_FILES["file"]["type"] == "image/x-png"
	        || $_FILES["file"]["type"] == "image/png"
	        && in_array($extension, $allowedExts)) {
            if ($_FILES["file"]["error"] > 0) {
                $respone['error'] = $_FILES["file"]["error"];
            } else {
            	$path = 'assets/upload/images/';
                $filename = strtolower($extension);
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $path.basename($filename))) {
                //	$this->db->where('id_user', $this->session->userdata('user_id'))
//                		->update('dghq_users', array('images' => $path.$filename));
                    $respone['success'] = $path.$filename;
                } else {
                    $respone['error'] = "Can not upload file";
                }
            }
        } else {
            $respone['error'] = "Invalid file";
        }
        $this->output->set_output(json_encode($respone));
    }
    
    function upload_avatar() {
        $allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPG", "JPEG", "PNG");
        $temp = explode(".", $_FILES["fileavatar"]["name"]);
        $extension = end($temp);

        $respone['error'] = '';
        $respone['success'] = '';
        
        if ($_FILES["fileavatar"]["type"] == "image/gif"
        	|| $_FILES["fileavatar"]["type"] == "image/jpeg"
        	|| $_FILES["fileavatar"]["type"] == "image/jpg"
	        || $_FILES["fileavatar"]["type"] == "image/pjpeg"
	        || $_FILES["fileavatar"]["type"] == "image/x-png"
	        || $_FILES["fileavatar"]["type"] == "image/png"
	        && in_array($extension, $allowedExts)) {
            if ($_FILES["fileavatar"]["error"] > 0) {
                $respone['error'] = $_FILES["fileavatar"]["error"];
            } else {
            	$path = 'assets/upload/avatar/';
                $filename = $this->session->userdata('user_id').'.'.strtolower($extension);
                if(move_uploaded_file($_FILES["fileavatar"]["tmp_name"], $path.basename($filename))) {
                	$this->db->where('user_id', $this->session->userdata('user_id'))
                		->update('login_users', array('avatar' => $path.$filename));
					//$files = scandir($path);
						/*echo "<pre>";print_r($files);exit;
						foreach($files as $k=>$file){
							if($k != 0 && $k != 1)
							$thumb = $this->resize_image('max',$path.basename($file),$path."thumb/".basename($file),100,100);
						}	*/
					$thumb = $this->resize_image('max',$path.basename($filename),$path."thumb/".basename($filename),100,100);
                    $respone['success'] = $path.$filename;
                } else {
                    $respone['error'] = "Can not upload file";
                }
            }
        } else {
            $respone['error'] = "Invalid file";
        }
        $this->output->set_output(json_encode($respone));
    }
    function view_user_home() {
        $sql = "select du.first_name, du.last_name, dui.profile, dui.education, dui.experiences, dui.interests
                from user_info dui, user du
                where dui.id_user = du.id
                and dui.id_user = '".$this->session->userdata('user_id')."';";
        $this->output->set_output(json_encode($this->db->query($sql)->row_array()));
    }
     function view_modal() {
		 $this->data->old_email = $this->db->where('id', $this->session->userdata('user_id'))->get('user')->row()->email;
        $this->data->detail_user = $this->user->get_detail_user($this->session->userdata('user_id'));
        
        //print_r($this->user->get_detail_user($this->session->userdata('user_id')));exit; 
        $this->load->view('profile/'.$this->input->post('modal_type'), $this->data);
    }
    function change_password() {
        $respone = 0;
        $old_password = real_escape_string($_POST['old_password']);
        $new_password = real_escape_string($_POST['new_password']);
		$query = $this->db->select('password, salt')
                ->where('id', $this->session->userdata('user_id'))
                ->limit(1)
                ->get('user');

        $hash_password_db = $query->row();

        if ($query->num_rows() !== 1) {
             $respone = 0;
        }else{
        // sha1
			 $salt = substr($hash_password_db->password, 0, 10);
			 $db_password = $salt . substr(sha1($salt . $old_password), 0, -10);
			if($db_password == $hash_password_db->password) {
				if(!empty($new_password)){
					$salt_2 = substr(md5(uniqid(rand(), true)), 0, 10);
					$new_password_db = $salt_2 . substr(sha1($salt_2 . $new_password), 0, -10);
					$data = array(
						'password' => $new_password_db,
						'remember_code' => NULL,
					);
					$this->db->where('id', $this->session->userdata('user_id'))
						->update('user', $data);
					$respone = 1;
				}
			}
		}
        $this->output->set_output(json_encode($respone));
    }
    
    
    function change_user_info() {
        $respone = 0;
        $first_name = real_escape_string($_POST['first_name']);
        $last_name = real_escape_string($_POST['last_name']);
        $profile = real_escape_string($_POST['profile']);
        $education = real_escape_string($_POST['education']);
        $experiences = real_escape_string($_POST['experiences']);
        $interests = real_escape_string($_POST['interests']);
        
        $sql = "UPDATE user, user_info
                SET first_name = '{$first_name}',last_name = '{$last_name}',education = '{$education}',`profile` = '{$profile}',experiences = '{$experiences}',interests = '{$interests}'
                WHERE user.id=user_info.id_user
                AND user.id = '{$this->session->userdata('user_id')}';";
        $respone = $this->db->query($sql);
        //$this->db->where('id_user', )
        //->update('dghq_users_info', array('first_name' => $first_name, 'last_name' => $last_name, 'education' => $education,'profile' => $profile, 'experiences' => $experiences, 'interests' => $interests));
        //$respone = 1;
        //print_r($first_name.$last_name.$education);exit;
        $this->output->set_output(json_encode($respone));
    }

    function change_email() {
        $respone = 0;
        $old_email = real_escape_string($_POST['old_email']);
        $new_email = real_escape_string($_POST['new_email']);
        if($old_email == $this->db->where('id', $this->session->userdata('user_id'))->get('user')->row()->email) {
            $this->db->where('id', $this->session->userdata('user_id'))
                ->update('user', array('email' => $new_email));
				
			//update login_user
			 $this->db->where('user_id', $this->session->userdata('user_id'))
                ->update('login_users', array('email' => $new_email));
				
            $respone = 1;
        }
        $this->output->set_output(json_encode($respone));
    }

   // function view_user() {
//        $sql = "select dui.id_user, du.first_name, du.last_name, dui.from, du.birthdate, dui.prof_phone, dui.prof_mobile, du.email,
//                dui.addr_street, dui.addr_city, dui.addr_country
//                from {$this->user->table_dghq_users_info} dui, {$this->user->table_dghq_users} du
//                where dui.id_user = du.id_user
//                and dui.id_user = '".$this->input->post('id_user')."';";
//        $this->output->set_output(json_encode($this->db->query($sql)->row_array()));
//    }
//    
//	function view_user_home() {
//        $sql = "select du.first_name, du.last_name, dui.profile, dui.education, dui.experiences, dui.interests
//                from {$this->user->table_dghq_users_info} dui, {$this->user->table_dghq_users} du
//                where dui.id_user = du.id_user
//                and dui.id_user = '".$this->session->userdata('id_user')."';";
//        $this->output->set_output(json_encode($this->db->query($sql)->row_array()));
//    }

    function update_user() {
        $respone = 0;
        foreach ($this->input->post() as $key => $value) {
            switch ($key) {
                case 'from':
                case 'prof_phone':
                case 'prof_mobile':
                case 'addr_street':
                case 'addr_city':
                case 'addr_country':
                    $data_info[$key] = real_escape_string($value);
                    break;
                default:
                    $data[$key] = real_escape_string($value);
                    break;
            }
        }

        $this->db->trans_start();
        
        $this->db->where('id', $this->session->userdata('user_id'))
            ->update('user', $data);

        $this->db->where('id', $this->session->userdata('user_id'))
            ->update('user_info', $data_info);

        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_complete();
            $respone = 1;
        }

        $this->output->set_output(json_encode($respone));
    }
	public function deleteImage(){
		$url = $_POST['attr'];
		$url_image = explode('assets',$url);
		$url_cut_image = "assets".$url_image[1]; 
		$data = array(
               'avatar' => ''
            );

		$this->db->where('avatar', $url_cut_image);
		$this->db->update('login_users', $data);
		$result = true;
		$this->output->set_output(json_encode($result));
	}
	
	function resize_image($method,$image_loc,$new_loc,$width,$height) {
		if (!is_array(@$GLOBALS['errors'])) { $GLOBALS['errors'] = array(); }
	 
		if (!in_array($method,array('force','max','crop'))) { $GLOBALS['errors'][] = 'Invalid method selected.'; }
	 
		if (!$image_loc) { $GLOBALS['errors'][] = 'No source image location specified.'; }
		else {
			if ((substr(strtolower($image_loc),0,7) == 'http://') || (substr(strtolower($image_loc),0,7) == 'https://')) { /*don't check to see if file exists since it's not local*/ }
			elseif (!file_exists($image_loc)) { $GLOBALS['errors'][] = 'Image source file does not exist.'; }
			$extension = strtolower(substr($image_loc,strrpos($image_loc,'.')));
			if (!in_array($extension,array('.jpg','.jpeg','.png','.gif','.bmp'))) { $GLOBALS['errors'][] = 'Invalid source file extension!'; }
		}
	 
		if (!$new_loc) { $GLOBALS['errors'][] = 'No destination image location specified.'; }
		else {
			$new_extension = strtolower(substr($new_loc,strrpos($new_loc,'.')));
			if (!in_array($new_extension,array('.jpg','.jpeg','.png','.gif','.bmp'))) { $GLOBALS['errors'][] = 'Invalid destination file extension!'; }
		}
	 
		$width = abs(intval($width));
		if (!$width) { $GLOBALS['errors'][] = 'No width specified!'; }
	 
		$height = abs(intval($height));
		if (!$height) { $GLOBALS['errors'][] = 'No height specified!'; }
	 
		if (count($GLOBALS['errors']) > 0) { $this->echo_errors(); return false; }
	 
		if (in_array($extension,array('.jpg','.jpeg'))) { $image = @imagecreatefromjpeg($image_loc); }
		elseif ($extension == '.png') { $image = @imagecreatefrompng($image_loc); }
		elseif ($extension == '.gif') { $image = @imagecreatefromgif($image_loc); }
		elseif ($extension == '.bmp') { $image = @imagecreatefromwbmp($image_loc); }
	 
		if (!$image) { $GLOBALS['errors'][] = 'Image could not be generated!'; }
		else {
			$current_width = imagesx($image);
			$current_height = imagesy($image);
			if ((!$current_width) || (!$current_height)) { $GLOBALS['errors'][] = 'Generated image has invalid dimensions!'; }
		}
		if (count($GLOBALS['errors']) > 0) { @imagedestroy($image); $this->echo_errors(); return false; }
	 
		if ($method == 'force') { $new_image = $this->resize_image_force($image,$width,$height); }
		elseif ($method == 'max') { $new_image = $this->resize_image_max($image,$width,$height); }
		elseif ($method == 'crop') { $new_image = $this->resize_image_crop($image,$width,$height); }
	 
		if ((!$new_image) && (count($GLOBALS['errors'] == 0))) { $GLOBALS['errors'][] = 'New image could not be generated!'; }
		if (count($GLOBALS['errors']) > 0) { @imagedestroy($image); $this->echo_errors(); return false; }
	 
		$save_error = false;
		if (in_array($extension,array('.jpg','.jpeg'))) { imagejpeg($new_image,$new_loc) or ($save_error = true); }
		elseif ($extension == '.png') { imagepng($new_image,$new_loc) or ($save_error = true); }
		elseif ($extension == '.gif') { imagegif($new_image,$new_loc) or ($save_error = true); }
		elseif ($extension == '.bmp') { imagewbmp($new_image,$new_loc) or ($save_error = true); }
		if ($save_error) { $GLOBALS['errors'][] = 'New image could not be saved!'; }
		if (count($GLOBALS['errors']) > 0) { @imagedestroy($image); @imagedestroy($new_image); $this->echo_errors(); return false; }
	 
		imagedestroy($image);
		imagedestroy($new_image);
	 
		return true;
	}
 
	function echo_errors() {
		if (!is_array(@$GLOBALS['errors'])) { $GLOBALS['errors'] = array('Unknown error!'); }
		foreach ($GLOBALS['errors'] as $error) { echo '<p style="color:red;font-weight:bold;">Error: '.$error.'</p>'; }
	}
	function resize_image_crop($image,$width,$height) {
		$w = @imagesx($image); //current width
		$h = @imagesy($image); //current height
		if ((!$w) || (!$h)) { $GLOBALS['errors'][] = 'Image couldn\'t be resized because it wasn\'t a valid image.'; return false; }
		if (($w == $width) && ($h == $height)) { return $image; } //no resizing needed
	 
		//try max width first...
		$ratio = $width / $w;
		$new_w = $width;
		$new_h = $h * $ratio;
	 
		//if that created an image smaller than what we wanted, try the other way
		if ($new_h < $height) {
			$ratio = $height / $h;
			$new_h = $height;
			$new_w = $w * $ratio;
		}
	 
		$image2 = imagecreatetruecolor ($new_w, $new_h);
		imagecopyresampled($image2,$image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
	 
		//check to see if cropping needs to happen
		if (($new_h != $height) || ($new_w != $width)) {
			$image3 = imagecreatetruecolor ($width, $height);
			if ($new_h > $height) { //crop vertically
				$extra = $new_h - $height;
				$x = 0; //source x
				$y = round($extra / 2); //source y
				imagecopyresampled($image3,$image2, 0, 0, $x, $y, $width, $height, $width, $height);
			} else {
				$extra = $new_w - $width;
				$x = round($extra / 2); //source x
				$y = 0; //source y
				imagecopyresampled($image3,$image2, 0, 0, $x, $y, $width, $height, $width, $height);
			}
			imagedestroy($image2);
			return $image3;
		} else {
			return $image2;
		}
	}
	function resize_image_max($image,$max_width,$max_height) {
		$w = imagesx($image); //current width
		$h = imagesy($image); //current height
		if ((!$w) || (!$h)) { $GLOBALS['errors'][] = 'Image couldn\'t be resized because it wasn\'t a valid image.'; return false; }
	 
		if (($w <= $max_width) && ($h <= $max_height)) { return $image; } //no resizing needed
	 
		//try max width first...
		$ratio = $max_width / $w;
		$new_w = $max_width;
		$new_h = $h * $ratio;
	 
		//if that didn't work
		if ($new_h > $max_height) {
			$ratio = $max_height / $h;
			$new_h = $max_height;
			$new_w = $w * $ratio;
		}
	 
		$new_image = imagecreatetruecolor ($new_w, $new_h);
		//$new_image = imagecreate($new_w, $new_h);
		imagecopyresampled($new_image,$image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
		return $new_image;
	}
	function resize_image_force($image,$width,$height) {
		$w = @imagesx($image); //current width
		$h = @imagesy($image); //current height
		if ((!$w) || (!$h)) { $GLOBALS['errors'][] = 'Image couldn\'t be resized because it wasn\'t a valid image.'; return false; }
		if (($w == $width) && ($h == $height)) { return $image; } //no resizing needed
	 
		$image2 = imagecreatetruecolor ($width, $height);
		imagecopyresampled($image2,$image, 0, 0, 0, 0, $width, $height, $w, $h);
	 
		return $image2;
	}
	
	
	function list_data() {
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);
		//$arrColumn = array('datetime','b/s','product','type_order','expiry','price','quantity');
		$headers = $this->tab->get_headers('vdm_order_user');
		//var_export($headers);
		//
		$where = " ";
        $aColumns = array();
        foreach ($headers as $item) {
			$column_field = '`'.$item['field'].'`';
			if($this->input->post(strtolower($item['field']))) {
				switch(strtolower($item['type'])) {
					case 'varchar':
					case 'longtext':
					case 'int':
					case 'link':
						$where .= " and {$column_field} like '%".($this->input->post(strtolower($item['field'])))."%'";
						break;
					case 'list':
						if($this->input->post(strtolower($item['field'])) != 'all') {
							$where .= " and {$column_field} = '".($this->input->post(strtolower($item['field'])))."'";    
						}
						break;
					default:
						break;
				}
			} elseif($this->input->post(strtolower($item['field'].'_start')) and strtotime($this->input->post(strtolower($item['field'].'_start')))) {
				$where .= " and {$column_field} >= '".($this->input->post(strtolower($item['field'].'_start')))."'";
			} elseif($this->input->post(strtolower($item['field'].'_end')) and strtotime($this->input->post(strtolower($item['field'].'_end')))) {
				$where .= " and {$column_field} <= '".($this->input->post(strtolower($item['field'].'_end')))."'";
			}
        }
		// order
        $order_by ='';	
        if (isset($_REQUEST['order'][0]['column'])) {
            $iSortCol_0 = $_REQUEST['order'][0]['column'];
            $sSortDir_0 = $_REQUEST['order'][0]['dir'];
            foreach($aColumns as $key => $value) {
                if($iSortCol_0 == $key) {                    
                    $order_by = " order by $value ".$sSortDir_0;
                    break;
                }
            }
        }        
		//
		$sql = "select count(*) as count
        from (select id from vdm_order_options_daily  where id_user='".$this->session->userdata('user_id')."' {$where}
        union all 
        select id  from vdm_order_futures_daily where id_user='".$this->session->userdata('user_id')."'
       {$where} ) as table_name ";
		 
        $iFilteredTotal = $this->db3->query($sql)->row()->count;
		$iTotalRecords = $iFilteredTotal;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
        $sql = "select sql_calc_found_rows vcr.format, str_id,datetime,A.dsymbol, order_type,`b/s`, type_order,type,strike, expiry, price, quantity, id_user,`status`
                from (select concat(id,'_','options')as str_id, datetime,dsymbol,order_type,`b/s`, 'Options' as type_order, type, strike, expiry, price, quantity,id_user,`status` from vdm_order_options_daily union all (select concat(id,'_','futures')as str_id, datetime,dsymbol,order_type,`b/s`,'Futures' as type_order, 0 as type, 0 as strike, expiry, price, quantity,id_user,`status`  from vdm_order_futures_daily)) as A LEFT JOIN vdm_contracts_ref vcr 
ON vcr.dsymbol = A.dsymbol where id_user='".$this->session->userdata('user_id')."' and date_format(datetime, '%Y-%m')=date_format(now(), '%Y-%m') {$where} Order By datetime {$order_by} DESC limit {$iDisplayStart}, {$iDisplayLength};";
		//echo "<pre>";print_r($sql);exit;
        $data = $this->db3->query($sql)->result_array();   

        $records = array();
        $records["data"] = array();
        foreach ($data as $key => $value) {
          foreach($headers as $item) {
			//  print_r( $value);
			//  print_r( $item['field']);
			  switch($item['align']) {
                    case 'L':
                        $align = ' class="align-left"';
                        break;
                    case 'R';
                        $align = ' class="align-right"';
                        break;
                    default:
                        $align = ' class="align-center"';
                        break;

                }
			  if($item['field']=='expiry' && ($value['type_order']=='Options')){
				  $records["data"][$key][] = '<div'.$align.'>'.($value['type']=='C' ? 'Call, ' : 'Put, ').date('M-Y',strtotime($value[$item['field']])).', '.number_format($value['strike'],2,'.', '').'</div>';
			  }
			  else if ($item['field']=='expiry' && ($value['type_order']=='Futures')){
				   $mmm = substr(strftime('%B',strtotime($value[$item['field']])),0,3);
           			$yy = strftime('%y',strtotime($value[$item['field']]));
			  	//$records["data"][$key][] = '<div'.$align.'>'.date('M-Y',strtotime($value[$item['field']])).'</div>';
				$records["data"][$key][] = '<div'.$align.'>'.strtoupper($mmm.'-'.$yy).'</div>';
				
			}
			 else if((strpos(strtolower($item['format_n']),'decimal')!==false)&&$value[strtolower($item['field'])]!=''){
						$start = strpos(strtolower($item['format_n']),'(') +1;
						$end = strpos(strtolower($item['format_n']),')');
						$str = ($start!==false && $end!==false) ? intval(substr($item['format_n'],$start,  $end - $start)) : 0;
						$records["data"][$key][] = '<div'.$align.'>'.number_format(($value[strtolower($item['field'])]), $str, '.', ',').'</div>';
			}
			else if($item['field']=='price'){
				if(isset($value['format'])){
					$find_format = strpos($value['format'],'.');
					$find_comma = strpos($value['format'],',');
					if(isset($find_format) && $find_format){
						$explode = explode(".",$value['format']);
						$get_decimal = strlen($explode[1]);
						if(isset($find_comma) && $find_comma) {
							$get_comma = ',';	
						}else{
							$get_comma = '';	
						}
					}
					else if(isset($find_comma) && $find_comma){
						$get_comma = ',';
						$get_decimal = 0;
					}
					else{
						$get_decimal = 0;
						$get_comma = '';	
					}
				}
				if($value[$item['field']] != 0){
					$records["data"][$key][] = '<div'.$align.'>'.number_format($value[$item['field']],$get_decimal,'.',$get_comma).'</div>';
				}else{
					$records["data"][$key][] ='<div'.$align.'>'.'-'.'</div>';	
				}
			}
			  else
			 	$records["data"][$key][] = '<div'.$align.'>'.$value[$item['field']].'</div>';
		  }
		  if($value["status"]==0){
				$records["data"][$key][] .='';
			}else{			
             $records["data"][$key][] .= '<center><div class="align-center">'
                                        .'<a class="btn default btn-xs red delete-order" keys="'.$value["str_id"].'" href="#" title="'.trans('cancel',TRUE).'">
                                        <i class="fa fa-trash-o"></i></as>'
                                        .'</div></center>';
			}
		  $records["data"][$key][] .='';
        }
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iFilteredTotal;
          
        $this->output->set_output(json_encode($records));
    }
	
	function list_excu() {
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);
		$name = isset($_REQUEST['tab'])?$_REQUEST['tab'] :'';
        $id = ($this->session->userdata('user_id')) ? $this->session->userdata('user_id') :0;
		$tab = $this->tab->get_tab($name);
		//config hidden
		 $hiddenConfig =  $this->tab->get_config('hidden');
		 $downloadFile =  $this->tab->get_config('file');
        // select columns
        $where = "where 1=1";
        $headers = $this->tab->get_headers($tab['table_name']);
        $aColumns = array();
        foreach ($headers as $item) {
            $aColumns[] = '`'.strtolower($item['field']).'`';
            if($this->input->post(strtolower($item['field']))) {
                switch(strtolower($item['type'])) {
                    case 'varchar':
                    case 'longtext':
                    case 'int':
					case 'link':
                        $where .= " and `{$item['field']}` like '%".($this->input->post(strtolower($item['field'])))."%'";
                        break;
                    case 'list':
                        if($this->input->post(strtolower($item['field'])) != 'all') {
                            $where .= " and `{$item['field']}` = '".($this->input->post(strtolower($item['field'])))."'";    
                        }
                        break;
                    default:
                        break;
                }
            } else if($this->input->post(strtolower($item['field'].'_start')) and strtotime($this->input->post(strtolower($item['field'].'_start')))) {
                $where .= " and `{$item['field']}` >= '".real_escape_string($this->input->post(strtolower($item['field'].'_start')))."'";
            } 
			 else if($this->input->post(strtolower($item['field'].'_from'))) {
                $where .= " and `{$item['field']}` >= ".(int)($this->input->post(strtolower($item['field'].'_from')))."";
            }
			if($this->input->post(strtolower($item['field'].'_end')) and strtotime($this->input->post(strtolower($item['field'].'_end')))){
				 $where .= " and `{$item['field']}` <= '".real_escape_string($this->input->post(strtolower($item['field'].'_end')))."'";
			}
			if($this->input->post(strtolower($item['field'].'_to'))) {
                $where .= " and `{$item['field']}` <= ".(int)($this->input->post(strtolower($item['field'].'_to')))."";
            } 
        }
		$sTable =(($tab['query']!='') && (!is_null($tab['query'])))?$tab['query']: ('(SELECT * FROM '.$tab['table_name']. ' WHERE user_buy = '.$id.' or user_sell = '.$id.') as sTable');		
        $sqlColumn = "SHOW COLUMNS FROM {$tab['table_name']};";  
		$arrColumn = $this->db3->query($sqlColumn)->result_array(); 
		foreach ($arrColumn as $item){			 		 
			 if(!$this->input->post(strtolower($item['Field'])) && isset($_GET[$item['Field']]) && strtolower($item['Field']!='tab'))
			 $where .= " and `{$item['Field']}` = '".$_GET[$item['Field']]."'";
		}
		 $sql = "select count(*) count
                from {$sTable} {$where}";
        $iFilteredTotal = $this->db3->query($sql)->row()->count;
		 $iTotalRecords = $iFilteredTotal;
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 

        // order
        $order_by ='';	
        if (isset($_REQUEST['order'][0]['column'])) {
            $iSortCol_0 = $_REQUEST['order'][0]['column'];
            $sSortDir_0 = $_REQUEST['order'][0]['dir'];
            foreach($aColumns as $key => $value) {
                if($iSortCol_0 == $key) {                    
                    $order_by = " order by $value ".$sSortDir_0;
                    break;
                }
            }
        }
        $order_by .= (($tab['order_by']!='') && (!is_null($tab['order_by'])))?($order_by =='' ? ('order by '.$tab['order_by']):(','.$tab['order_by'])):'';
		$sqlkey = "SELECT `keys`, `user_level` FROM vdm_summary WHERE table_name = '{$tab['table_name']}'";
        $keyARR = $this->db3->query($sqlkey)->row_array();
		$keyARR = isset( $keyARR) ? $keyARR: array();
		$arr = explode(',',$keyARR['keys']);
        foreach($arr as $v){ 
            $aa[] = '`'.TRIM($v).'`';
        }   
        $rs = in_array($aa, $aColumns, TRUE) ?  $aColumns : array_merge((array)$aa, (array)$aColumns);
        
        $sql = "select sql_calc_found_rows " . str_replace(' , ', ' ', implode(', ', $rs)) . "
                from {$sTable} {$where} {$order_by} limit {$iDisplayStart}, {$iDisplayLength};";
        $data = $this->db3->query($sql)->result_array();
		$ke = explode(',',$keyARR['keys']);
        //$aColumns[] = '`'.strtolower($item['field']).'`';
        
        $arr = explode(',',$keyARR['keys']);
        foreach($arr as $v){ 
            $aa[] = '`'.TRIM($v).'`';
        }
		$edit_table =  $this->tab->get_config('edit_table');    
        $records = array();
        $records["data"] = array();
        foreach ($data as $key => $value) {
            foreach($headers as $item) {
                switch($item['align']) {
                    case 'L':
                        $align = ' class="align-left"';
                        break;
                    case 'R';
                        $align = ' class="align-right"';
                        break;
                    default:
                        $align = ' class="align-center"';
                        break;
                }
				if(trim($value[strtolower($item['field'])])=='-')
					$records["data"][$key][] = '<div'.$align.'></div>';
				else if(($item['hidden']==1)&&(isset($hiddenConfig['value']) && ($this->session->userdata('user_level')<$hiddenConfig['value']))){
					$length = strlen($value[strtolower($item['field'])]);
					if((strpos(strtolower($item['type']),'efrc_link')!==false)&&$value[strtolower($item['field'])]!=''){
						$start = strpos(strtolower($item['type']),'(')+1;
						$end = strpos(strtolower($item['type']),')')+1;
						$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : 'Link';
						$records["data"][$key][] = '<div'.$align.'><a class="btn default btn-xs green" href="'.base_url().$value[strtolower($item['field'])].'">
									<i class="fa fa-globe"></i> '.trim($str).' </a></div>';
						
					}
					else if((strpos(strtolower($item['type']),'link')!==false)&&$value[strtolower($item['field'])]!=''){
						$start = strpos(strtolower($item['type']),'(');
						$end = strpos(strtolower($item['type']),')');
						$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : 'Link';
						if(strpos($value[strtolower($item['field'])], 'http')===false && strpos($value[strtolower($item['field'])], 'https')===false)
						$records["data"][$key][] = '<div'.$align.'><a class="btn default btn-xs green" href="http://'.$value[strtolower($item['field'])].'" target="_blank">
									<i class="fa fa-globe"></i> '.trim($str).' </a></div>';							
						
						else {
							$records["data"][$key][] = '<div'.$align.'><a class="btn default btn-xs green" href="'.$value[strtolower($item['field'])].'" target="_blank">
									<i class="fa fa-globe"></i> '.trim($str).' </a></div>';
							
						}
					} else if((strtolower($item['type'])=='file')&&$value[strtolower($item['field'])]!=''){
						if(isset($downloadFile['value']) && $downloadFile['value']<=$this->session->userdata('user_level'))
						$records["data"][$key][] = '<div'.$align.'><a  href="'.base_url().'assets/upload/pdf/'.$value[strtolower($item['field'])].'" download="'.$value[strtolower($item['field'])].'">
									<img src="'.base_url().'assets/templates/welcome/img/pdf.png" style="height:30px; width:30px;"> </a></div>';
						else $records["data"][$key][]='';
						
					}
					else if((strpos(strtolower($item['type']),'image')!==false)){
						$start = strpos(strtolower($item['type']),'(') +1;
						$end = strpos(strtolower($item['type']),')');
						$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : '';
						$arrHeight = explode(',', $str);
						$height = (isset($arrHeight[0]) && $arrHeight[0] >0) ?  $arrHeight[0]: 20;
						$heightMax = (isset($arrHeight[1]) && $arrHeight[1] >0 ) ?  $arrHeight[1]: 200;
						$image =$value[strtolower($item['field'])]!=''? '<img height="'.$height.'" src="'.base_url().$value[strtolower($item['field'])].'" class="thumb" data-height="'.$heightMax.'" >' :'';
						
						$records["data"][$key][] = '<div'.$align.'>'.$image.'</div>';
						
					}
                    else if((strpos(strtolower($item['format_n']),'decimal')!==false)&&$value[strtolower($item['field'])]!=''){
						$start = strpos(strtolower($item['format_n']),'(') +1;
						$end = strpos(strtolower($item['format_n']),')');
						$str = ($start!==false && $end!==false) ? intval(substr($item['format_n'],$start,  $end - $start)) : 0;
						$records["data"][$key][] = '<div'.$align.'>'.number_format(($value[strtolower($item['field'])]), $str, '.', ',').'</div>';
				    }
					else if((strpos(strtolower($item['format_n']),'decimal')!==false)&&$value[strtolower($item['field'])]!=''){
						$start = strpos(strtolower($item['format_n']),'(') +1;
						$end = strpos(strtolower($item['format_n']),')');
						$str = ($start!==false && $end!==false) ? intval(substr($item['format_n'],$start,  $end - $start)) : 0;
						$records["data"][$key][] = '<div'.$align.'>'.number_format(($value[strtolower($item['field'])]), $str, '.', ',').'</div>';
				    }
					else
					$records["data"][$key][] = '<div'.$align.'>'.str_repeat('*',$length).'</div>';
				}
				else {
					if((strpos(strtolower($item['type']),'efrc_link')!==false)&&$value[strtolower($item['field'])]!=''){
						$start = strpos(strtolower($item['type']),'(')+1;
						$end = strpos(strtolower($item['type']),')');
						$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : 'Link';					
                		$records["data"][$key][] = '<div'.$align.'><a class="btn default btn-xs green" href="'.base_url().$value[strtolower($item['field'])].'">
									<i class="fa fa-globe"></i> '.trim($str).' </a></div>';
					}
					else if((strpos(strtolower($item['type']),'link')!==false)&&$value[strtolower($item['field'])]!=''){
						$start = strpos(strtolower($item['type']),'(') +1;
						$end = strpos(strtolower($item['type']),')');
						$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : 'Link';
						if(strpos($value[strtolower($item['field'])], 'http')===false && strpos($value[strtolower($item['field'])], 'https')===false)
						$records["data"][$key][] = '<div'.$align.'><a class="btn default btn-xs green" href="http://'.$value[strtolower($item['field'])].'" target="_blank">
									<i class="fa fa-globe"></i> '.trim($str).' </a></div>';							
						
						else {
							
							$records["data"][$key][] = '<div'.$align.'><a class="btn default btn-xs green" href="'.$value[strtolower($item['field'])].'" target="_blank">
									<i class="fa fa-globe"></i> '.trim($str).' </a></div>';
							
						}
					}						
					else if((strtolower($item['type'])=='file')&&$value[strtolower($item['field'])]!=''){
						if(isset($downloadFile['value']) && $downloadFile['value']<=$this->session->userdata('user_level'))
						$records["data"][$key][] = '<div'.$align.'><a  href="'.base_url().'assets/upload/pdf/'.$value[strtolower($item['field'])].'" download="'.$value[strtolower($item['field'])].'">
									<img src="'.base_url().'assets/templates/welcome/img/pdf.png" style="height:30px; width:30px;"> </a></div>';
						else $records["data"][$key][]='';
						
					}
					else if((strpos(strtolower($item['type']),'image')!==false)){
						$start = strpos(strtolower($item['type']),'(') +1;
						$end = strpos(strtolower($item['type']),')');
						$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : '';
						$arrHeight = explode(',', $str);
						$height = (isset($arrHeight[0]) && $arrHeight[0] >0) ?  $arrHeight[0]: 20;
						$heightMax = (isset($arrHeight[1]) && $arrHeight[1] >0 ) ?  $arrHeight[1]: 200;
						$image =$value[strtolower($item['field'])]!=''? '<img height="'.$height.'" src="'.base_url().$value[strtolower($item['field'])].'" class="thumb" data-height="'.$heightMax.'" >' :'';
						$records["data"][$key][] = '<div'.$align.'>'.$image.'</div>';
						
					}
                    else if ((strpos(strtolower($item['format_n']),'date')!==false)&&$value[strtolower($item['field'])]!=''){
                        $start = strpos(strtolower($item['format_n']),'(') +1;
						$end = strpos(strtolower($item['format_n']),')');
						$str = ($start!==false && $end!==false) ? substr($item['format_n'],$start,  $end - $start) : 0;
				        $records["data"][$key][] = '<div'.$align.'>'.date($str,strtotime($value[strtolower($item['field'])])).'</div>';
				    }
					else if((strpos(strtolower($item['format_n']),'decimal')!==false)&&$value[strtolower($item['field'])]!=''){
						$start = strpos(strtolower($item['format_n']),'(') +1;
						$end = strpos(strtolower($item['format_n']),')');
						$str = ($start!==false && $end!==false) ? intval(substr($item['format_n'],$start,  $end - $start)) : 0;
						$records["data"][$key][] = '<div'.$align.'>'.number_format(($value[strtolower($item['field'])]), $str, '.', ',').'</div>';
				    }
					else
					$records["data"][$key][] = '<div'.$align.'>'.$value[strtolower($item['field'])].'</div>';
				}
            }
            $keys = array();
            foreach($ke as $val){
			   $keys[] = "'".$value[strtolower($val)]."' ";
		    }
			//print_r($keys);
			$k = implode(',',$keys);
            //$records["data"][$key][] = '';
			$records["data"][$key][] .='';
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iFilteredTotal;
          
        $this->output->set_output(json_encode($records));
    }
	
	public function elfinder_init(){
	  //echo "<pre>";print_r(base_url('files') . '/');exit;
	  $opts = array(
	    // 'debug' => true, 
	    'roots' => array(
	      array( 
	        'driver' => 'LocalFileSystem', 
	        'path'   => $_SERVER['DOCUMENT_ROOT'].'/simulation/files', 
	        'URL'    => base_url('files') . '/'
	        // more elFinder options here
	      ) 
	    )
	  );
	  $this->load->library('elfinder_lib', $opts);
	}
	

}
