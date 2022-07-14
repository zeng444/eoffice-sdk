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
    $list = $client->getFlow()->list(1, 1, 1, ["transact_time" => "desc"], [

        "run_seq_strip_tags" => [202207141012],
//        "run_id"=> [223],
        "flow_id" => [50],
    ]);
    print_r($list);

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
