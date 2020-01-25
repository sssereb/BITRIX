<?php

// 



$deal_id = $ID_IN['FIELDS']['ID'];



$deal_data = executeREST('crm.deal.get', array('ID' => intval($ID_IN['data']['FIELDS']['ID'])));



$main_kp = $deal_data['result']['QUOTE_ID'];

$main_lead = $deal_data['result']['LEAD_ID'];

$kp_id = $ID_IN['FIELDS']['ID'];

$kp_data = executeREST('BX24.callMethod(	"crm.quote.list", 	{ 		order: { "STATUS_ID": "ASC" },		
filter: { "=LEAD_ID": $main_lead },		select: [ "ID",  "STATUS_ID" ]	}, 	function(result){})', 
array('ID' => intval($_REQUEST2['data']['FIELDS']['ID'])));



foreach ($kp_data as $kp_id)
{
if ($kp_data['result']['ID'] == $main_kp) 
executeREST ('crm.quote.update', 
array($crm[result],
array('ID' => $kp_data['result']['ID'], 
      'FIELDS' => '{ "STATUS_ID": "APPROVED" }')));
if ($kp_data['result']['ID'] == $main_kp) 
executeREST ('crm.quote.update', 
array($crm[result],
array('ID' => $kp_data['result']['ID'], 
      'FIELDS' => '{ "STATUS_ID": "DECLAINED"  }')));
}

function executeREST($method, $params) {

 
   $queryUrl = 'https://comcompany.bitrix24.ua/rest/1/jf43c29vkjox8tqm/'.$method.'.json';
 
   $queryData = http_build_query($params);

 
   $curl = curl_init();
   
 curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
       
 CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
       
 CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));

  

  $result = curl_exec($curl);
    curl_close($curl);

    return json_decode($result, true);

}
