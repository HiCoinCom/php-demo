<?php

require("vendor/autoload.php");


$config = new chainup\waas\client\Config();
//设置接口域名
//$config->setDomain();
//设置waas app id
$config->setAppid("your app id");
//设置商户自己生成 的私钥
$config->setUserPrivateKey("your rsa private key");
//设置waas平台用的公钥
$config->setWaasPublicKey("waas public key");

$client = new chainup\waas\client\WaasClient($config);
//获取支持的币种列表
var_dump($client->getCoinList()->getCode());

//注册邮箱用户
var_dump($client->CreateEmailUser("test@admin.com"));

//获取用户信息
$emailUser = $client->GetUserInfoByEmail("test@admin.com");
$uid = $emailUser->getData()["uid"];
var_dump($emailUser);

//获取用户币种余额
var_dump($client->GetBalanceByUidAndSymbol($uid, "ETH"));

//获取归集账户余额
var_dump($client->GetCollectBalanceBySymbol("ETH"));

//获取币种充值地址
var_dump($client->GetDepositAddress($uid, "ETH"));

//提现订单号
$tradeNo = "123456543932";
//发起提现
var_dump($client->Withdraw($tradeNo, $uid, "", "1.009", "ETH"));

$waasTransIds = array(1, 1000, 2000);
//同步提现记录, 参数为waas返回的id, 每次传waas返回的最大id 实现分页同步
var_dump($client->SyncWithdrawList($waasTransIds[0])->getCode());

//批量查询提现记录，参数为商户自己生成的订单号
var_dump($client->WithdrawBatchList(array($tradeNo, "abcd123456"))->getCode());

//同步充值记录 参数与同步提现记录一致
var_dump($client->SyncDepositList($waasTransIds[1])->getCode());

//批量查询充值记录 参数与同步提现记录一致
var_dump($client->DepositBatchList($waasTransIds)->getCode());