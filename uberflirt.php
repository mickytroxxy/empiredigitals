<?php
header("Access-Control-Allow-Origin: *");
if (isset($_GET['reference']) && $_GET['reference'] && isset($_GET['amount']) && $_GET['amount']) {
    $encryptionKey = 'test';

	$DateTime = new DateTime();

	$data = array(
	    'PAYGATE_ID'        => 1033272100019,
	    'REFERENCE'         => trim($_GET["reference"]),
	    'AMOUNT'            => trim($_GET["amount"]),
	    'CURRENCY'          => 'ZAR',
	    'RETURN_URL'        => 'https://www.uberflirt.techapis.xyz/payFastSuccess',
	    'TRANSACTION_DATE'  => $DateTime->format('Y-m-d H:i:s'),
	    'LOCALE'            => 'en-za',
	    'COUNTRY'           => 'ZAF',
	    'EMAIL'             => 'customer@paygate.co.za',
	);

	$checksum = md5(implode('', $data) . $encryptionKey);

	$data['CHECKSUM'] = $checksum;

	$fieldsString = http_build_query($data);

	//open connection
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_URL, 'https://secure.paygate.co.za/payweb3/initiate.trans');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_NOBODY, false);
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);

	//execute post
	$result = curl_exec($ch);
	echo $result;
	//close connection
	curl_close($ch);

    //echo json_encode(array('success' => 1));
} else {
    echo json_encode(array('success' => 0));
}