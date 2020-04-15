<?php

// localhost/my_projects/YAMAHA/api/creator/support/getInquiryMessageIdCreatedId.php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: Application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once ('../../config/database.php');

	include_once ('../../obj/encryption.php');

	include_once ('../../obj/users.php');

	session_start();

	$des = array();

	$errors = array();

	$res = array();

	$mes = array();

	$db = new Database();

	$connection = $db->connection();

	$admin = new User($connection);

	$encryption = new Encryption();

	$userData = file_get_contents('php://input');

	$raw = json_decode($userData);

	// $admin->customerInfoId = 1;
	$admin->customerInfoId = $raw->inquiryInformationID->id;

	if($stmt = $admin->getInquiryMessageIdCreatedId()){

		$count = $stmt->rowCount();

		if($count > 0){

			//data
			if($data = $stmt->fetch(PDO::FETCH_ASSOC)){

				$result = array(

					'keys' => array(

						"inquiryId" => $data['inquiryId'],
						"personalInformationId" => $data['personalInformationId'],
						
					)

				);

				$jsonDataResult = json_decode(json_encode($result));


				if($jsonDataResult->keys->inquiryId == null || empty($jsonDataResult->keys->inquiryId)){

					$reason = 'failed';

					$status = 400;

					$error = 'no created inquiry id';

					$message = 'incomplete';

					array_push($errors, $error);

					array_push($mes, $message);

					goto endResult;

				}else if($jsonDataResult->keys->personalInformationId == null || empty($jsonDataResult->keys->personalInformationId)){

					//error null value no data
					$reason = 'failed';

					$status = 400;

					$error = 'no personal information id';

					$message = 'incomplete';

					array_push($errors, $error);

					array_push($mes, $message);

					goto endResult;

				}else{

					$useriv = $encryption->ivData();

					$one = $encryption->encryptData($raw->inquiryInformationID->adminReply, $useriv);
					$two = $raw->inquiryInformationID->messageType;
					$three = base64_encode($useriv);

					$binddata = $one . $two . $three;

					$four = $encryption->dataHashing($binddata, $useriv);
					
					$messageJson = json_decode(
						json_encode(
							array(
								'message' => $one,
								'type' => $two,
								'ivKey' => $three,
								'hash' => $four
							)
						)
					);

					$admin->inquiryMessage = $messageJson->message;
					$admin->messageType = $messageJson->type;
					$admin->salt = $messageJson->ivKey;
					$admin->hash = $messageJson->hash;

					if($admin->createdMessage()){

						// successfully inserted get message id
						$admin->hash_data = $messageJson->hash;

						if($stmt = $admin->getMessageInformationId()){

							//success
							$count = $stmt->rowCount();

							if($count > 0){
								//data
								if($messageData = $stmt->fetch(PDO::FETCH_ASSOC)){

									//success insert in to database

									if(empty($admin->createdDate = date('y-m-d'))){
										$error = 'no date';
										array_push($errors, $error);
									}elseif (empty($admin->timeCreated = date('h:i:s'))) {
										$error = 'no time';
										array_push($errors, $error);
									}elseif (empty($admin->inquiryId = $jsonDataResult->keys->inquiryId)) {
										$error = 'no created inquiry id';
										array_push($errors, $error);
									}elseif (empty($admin->adminId = $raw->inquiryInformationID->AdminAccountId)) {
										$error = 'no admin id';
										array_push($errors, $error);
									}


									$admin->timeCreated = date('h:i:s');
									$admin->messageID = $messageData['m_id'];
									$admin->inquiryId = $jsonDataResult->keys->inquiryId;
									$admin->adminId = $raw->inquiryInformationID->AdminAccountId;

									if($admin->sendMessagetoOneInquiry()){

										//success

										$reason = 'success';

										$status = 200;

										$error = 'none';

										$message = 'message successfully sent';

										array_push($errors, $error);

										array_push($mes, $message);

										goto endResult;

									}else{

										//error
										$reason = 'failed';

										$status = 400;

										$error = 'incomplete';

										$message = 'no data';

										array_push($errors, $error);

										array_push($mes, $message);

										goto endResult;
									}


								}else{

									//error
									$reason = 'failed';

									$status = 400;

									$error = 'data cannot be fetch';

									$message = 'internal error';

									array_push($errors, $error);

									array_push($mes, $message);

									goto endResult;
								}
							}else{
								//nodata
								$reason = 'failed';

								$status = 400;

								$error = 'no data in database';

								$message = 'no data';

								array_push($errors, $error);

								array_push($mes, $message);

								goto endResult;
							}

						}else{

							//error
							$reason = 'no data';

							$status = 400;

							$error = 'query getting error';

							$message = 'no data';

							array_push($errors, $error);

							array_push($mes, $message);

							goto endResult;
						}

					}else{

						// error
						//error
						$reason = 'no data';

						$status = 400;

						$error = 'query inserting error';

						$message = 'no data';

						array_push($errors, $error);

						array_push($mes, $message);

						goto endResult;
					}

				}
				
			}// end of if

		}else{
			// no data

			$reason = 'no data';

			$status = 200;

			$error = 'none';

			$message = 'no data';

			array_push($errors, $error);

			array_push($mes, $message);

			goto endResult;
		}

	}else{

		//error
		$reason = 'no data';

		$status = 200;

		$error = 'query';

		$message = 'no data';

		array_push($errors, $error);

		array_push($mes, $message);

		goto endResult;

	}

	endResult:

	$result_array = array($mes, $reason, $status, $errors);

	for ($i = 0; $i < count($result_array); $i++) { 
		# code...
		if(empty($result_array[$i])){

			$result_array[$i] = null;

		}

	}

	$apiResult = json_encode(

		array(

			'response' => array(

				'reason' => $reason,
				'http_response_code' => $status,
				'errors' => $errors,
				'display' => array(
					'message' => $mes

				)
				// 'result' => array(
				// 	'data' => $res
				// )

			)

		)

	);

	echo  $apiResult;