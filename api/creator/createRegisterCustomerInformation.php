<?php

	// localhost/my_projects/yamaha_elective/api/creator/createRegisterCustomerInformation.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../config/database.php');

	include_once ('../obj/encryption.php');

	include_once ('../obj/users.php');

	$errors = array();

	$mes = array();
	
	$db = new Database();

	$connection = $db->connection();

	$userData = file_get_contents('php://input');

	if(empty($userData)){

		goto nullData;
	}

	$userData_raw = json_decode($userData);

	$encrypt = new Encryption();

	$useriv = $encrypt->ivData();

	$ci_email = $userData_raw->UserInformation->ci_email;
	$ci_firstname = $encrypt->encryptData($userData_raw->UserInformation->ci_firstname, $useriv);
	$ci_lastname = $encrypt->encryptData($userData_raw->UserInformation->ci_lastname, $useriv);
	$ci_middlename = $encrypt->encryptData($userData_raw->UserInformation->ci_middlename, $useriv);
	$ci_street = $encrypt->encryptData($userData_raw->UserInformation->ci_street, $useriv);
	$ci_city_municipality = $encrypt->encryptData($userData_raw->UserInformation->ci_city_municipality, $useriv);
	$ci_province = $encrypt->encryptData($userData_raw->UserInformation->ci_province, $useriv);
	$ci_zipcode = $encrypt->encryptData($userData_raw->UserInformation->ci_zipcode, $useriv);
	$ci_phonenumber = $encrypt->encryptData($userData_raw->UserInformation->ci_phonenumber, $useriv);
	$ci_telephonenumber = $encrypt->encryptData($userData_raw->UserInformation->ci_telephonenumber, $useriv);
	$ci_date = date("Y-m-d");
	$ci_bday = $userData_raw->UserInformation->ci_bday;

	$binddata = $ci_email . $ci_firstname . $ci_lastname . $ci_middlename . $ci_street . $ci_city_municipality . $ci_province . $ci_zipcode . $ci_phonenumber . $ci_telephonenumber . $ci_date . $ci_bday;

	$computedhash = $encrypt->dataHashing($binddata, $useriv);

	$user_iv_res = base64_encode($useriv);

	$raw_data = json_decode(
					json_encode(
						array(
							'customer_information' => array(

								'email' => $ci_email, 
								'firstname' => $ci_firstname,
								'lastname' => $ci_lastname,
								'middlename' => $ci_middlename,
								'street' => $ci_street,
								'municipality' => $ci_city_municipality,
								'province' => $ci_province,
								'zipcode' => $ci_zipcode,
								'phonenumber' => $ci_phonenumber,
								'telephone' => $ci_telephonenumber,
								'date' => $ci_date,
								'birthday' => $ci_bday,
								'security' => array(
									'salt' => $user_iv_res,
									'computedhash' => $computedhash
								)
							)
						)
					)
				);


	if(
		empty($raw_data->customer_information->email) &&
		empty($raw_data->customer_information->firstname) &&
		empty($raw_data->customer_information->lastname) &&
		empty($raw_data->customer_information->middlename) &&
		empty($raw_data->customer_information->street) &&
		empty($raw_data->customer_information->municipality) &&
		empty($raw_data->customer_information->province) &&
		empty($raw_data->customer_information->zipcode) &&
		empty($raw_data->customer_information->phonenumber) &&
		empty($raw_data->customer_information->telephone) &&
		empty($raw_data->customer_information->date) &&
		empty($raw_data->customer_information->birthday)
	 ){

	 	goto nullData;

	}

	if(empty($raw_data->customer_information->security->salt)){

		goto nullData;

	}

	if(empty($raw_data->customer_information->security->computedhash)){

		goto nullData;

	}

	$customer_user = new User($connection);

	$customer_user->email = $raw_data->customer_information->email;
	$customer_user->firstname = $raw_data->customer_information->firstname;
	$customer_user->lastname = $raw_data->customer_information->lastname;
	$customer_user->middlename = $raw_data->customer_information->middlename;
	$customer_user->street = $raw_data->customer_information->street;
	$customer_user->city = $raw_data->customer_information->municipality;
	$customer_user->province = $raw_data->customer_information->province;
	$customer_user->zipcode = $raw_data->customer_information->zipcode;
	$customer_user->phonenumber = $raw_data->customer_information->phonenumber;
	$customer_user->telephone = $raw_data->customer_information->telephone;
	$customer_user->date = $raw_data->customer_information->date;
	$customer_user->bday = $raw_data->customer_information->birthday;
	$customer_user->salt = $raw_data->customer_information->security->salt;
	$customer_user->hash = $raw_data->customer_information->security->computedhash;

	if(!($customer_user->create_userInformation())){

		goto nullData;

	}

	require '../mailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;
	$mail->isSMTP();

	$mail->Host ='smtp.gmail.com';

	$mail->Port = 587;

	$mail->SMTPAuth= true;

	$mail->SMTPSecure  = 'tls';


	$mail->Username = 'schooltestingpurposes01@gmail.com';

    $mail->Password= 'yps11d62email';

    $mail->setFrom('schooltestingpurposes01@gmail.com', 'bernard');

    $mail->addAddress('nhardbalansag@gmail.com');

    $mail->addReplyTo('schooltestingpurposes01@gmail.com');

	$mail->isHTML(true);

	$mail->Subject = 'Verification Code test';

	$mail->Body = 'testing lang ng email sending';

	if(!$mail->send()){

		$error = 'unable to send email';

	}else{

		$error = 'email sent';

	}

	$ref = $raw_data->customer_information->security->computedhash;

	$reason = 'success';

	$status = 200;

	array_push($errors, $error);

	goto endResult;

	nullData:

		$ref = 'null';

		$reason = 'incomplete';

		$status = 400;

		$error = 'null';

		$message = 'cannot register';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	endResult:

		$apiResult = json_encode(

			array(

			'response' => array(

					'reason' => $reason,
					'http_response_code' => $status,
					'errors' => $error,
					'display' => array(
						'message' => $mes,
						'referenceCode' => $ref

					)

				)

			)

		);

	echo  $apiResult;