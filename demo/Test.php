<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Janfish\EOffice\SDK as EOfficeSDK;

try {
    $config = [
        'apiPrefix' => 'http://192.168.10.242:8010/eoffice10/server/public/',
        'agentId' => '100001',
        'secret' => 'B771nF3FqMCJuaUuv74AhcfXwp5hia7o',
        'user' => 'zengweiqi',
        'timeout' => 30,
    ];
    $client = new EOfficeSDK($config);

    $flowTitle = "测试C";
    $flowId = 49;

    //创建流程
    $flow = $client->getFlow()->create(49, $flowTitle, '313123124124234214', [
        'DATA_1' => 'zengweiqi',
        'DATA_19' => '12',
        'DATA_27' => '12',
        'DATA_20' => '二十',
        'DATA_26' => 'WV00000004,2022-07-12 17:41:17',
        'DATA_4' => [
            [
                'DATA_4_1' => [],
                'DATA_4_1_TEXT' => '',
                'DATA_4_2' => "20", //单价
                'DATA_4_3' => "160", //金额小计
                'DATA_4_5' => 8, //数量
                'DATA_4_9' => "采购",  //备注
            ]
        ],
        'DATA_14' => '1',
        'DATA_16' => '2022-07-12',
    ]);

    print_r($flow);

    $flow = $client->getFlow()->save($flow['run_id'], 186, [
        'DATA_1' => 'zengweiqi',
        'DATA_19' => '12',
        'DATA_26' => 'WV00000004,2022-07-12 17:41:17',
        'DATA_27' => '12',
        'DATA_20' => '二十',
        'DATA_4' => '123123',
        'DATA_14' => '1',
        'DATA_16' => '2022-07-12',
    ]);

    print_r($flow);

//    $result = $client->getFlow()->submit($flow['run_id'], 186, 'zengweiqi', 'zhouting', 186, 186, '', [], 'turn');
//
//    print_r($result);

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
