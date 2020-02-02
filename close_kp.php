<?php

$id = $_GET['id'];

$deal_data = executeREST('crm.deal.get', array ( "ID" => $id));
$main_quote_id = $deal_data['result']['QUOTE_ID'];
$main_lead_id = $deal_data['result']['LEAD_ID'];
$DEAL_OPPORTUNITY = $deal_data['result']['OPPORTUNITY'];

$DEAL_UPDATE = executeREST ('crm.deal.userfield.update', array('ID' => $id, 
                                                               'FIELDS' => array ( "UF_CRM_5DF76EFB9E9CA" =>  $DEAL_OPPORTUNITY)));

$quote_data = executeREST('crm.quote.list', array ( 'order'  => array ( "STATUS_ID"  => "ASC"  ),
                                                    'filter' => array ( "LEAD_ID" =>  $main_lead_id ),
                                                    'select' => array ( "ID", "TITLE", "STATUS_ID", "OPPORTUNITY", "CURRENCY_ID" )));

foreach ($quote_data['result'] as $q_id)
{
if ($q_id['ID'] == $main_quote_id) 
executeREST ('crm.quote.update', array('ID' => $q_id['ID'], 
                                       'FIELDS' => array ( "STATUS_ID" =>  "APPROVED",
                                                           "DEAL_ID"   => $id)));
   
    
if ($q_id['ID'] <> $main_quote_id) 
executeREST ('crm.quote.update', array('ID' => $q_id['ID'], 
                                       'FIELDS' => array ( "STATUS_ID" =>  "DECLAINED" )));
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
        CURLOPT_POSTFIELDS => $queryData));
 $result = curl_exec($curl);
 return json_decode($result, true);
 curl_close($curl);

} ?>
