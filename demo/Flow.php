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

    //流程标题
    $flowTitle = "zengweiqi弟弟的业务支付申请";

    //创建流程ID，这个写死，id50为“业务支付申请”表
    $flowId = 50;

    //必须包裹div否则会创建失败
    $content = '<div><h3>' . $flowTitle . '</h3></div>';

    $form = [
        //表头标题
        'DATA_86' => "1", //选项标识
        'DATA_86_TEXT' => "成都市云瑞铭博企业管理有限公司", //选项值

        //申请日期
        'DATA_100' => "2022-07-13",

        //招标人
        'DATA_87' => "3",//选项标识
        'DATA_87_TEXT' => "四川鸿运欣智科技有限公司",//选项值

        //招标人性质
        'DATA_85' => "1", //选项标识
        'DATA_85_TEXT' => "一般纳税人", //选项值

        //比例（0.28表示28%）
        'DATA_88' => 0.28,

        //招标金额
        'DATA_89' => 12,

        //细项
        'DATA_101' => [
            [
                'DATA_101_3' => "红星路冯梧夏", //投标方
                'DATA_101_4' => "冯举", //投标方收款户名
                'DATA_101_6' => "51515151517844", //收款银行账号

                //支付方式
                'DATA_101_5' => "1",  //选项标识
                'DATA_101_5_TEXT' => "现金", //选项值

                'DATA_101_7' => "四川支行", //开户行
                'DATA_101_8' => 21, //平台支付金额
                'DATA_101_9' => "2022-07-13", //要求付款时间
                'DATA_101_10' => "2022-07-14", //收款时间
            ]
        ],

        'DATA_102' => "31", //平台支付总金额（小写），需要自动计算明细（DATA_101节点下DATA_101_8值的和）计算总额
        'DATA_103' => "31", //平台支付总金额（大写）,写的和DATA_102一样即可
        'DATA_101_8_amount' => "31", //汇总即可（可以不填写）
        'DATA_81' => "备注", //备注
        'DATA_96' => "系统管理员", //申请人
        'DATA_97' => "",//财务审核（创建不填写）
        'DATA_98' => "",//财务主管审核（创建不填写）
        'DATA_99' => "",//负责人审核（创建不填写）
    ];

    //创建流程
    $result = $client->getFlow()->create(50, $flowTitle, $content, $form);

    print_r($result);

    $process_id = 1;

    $run_id = $result['run_id'];
    $flowRunProcessId = $result['flow_run_process_id'];

    $processHost = 'WV00000002'; //此处使用userId，来自User()->list接口
    $result = $client->getFlow()->submit($run_id, $process_id, $flowRunProcessId, $processHost, '', '189', '190', '',
        [], 'turn');

    print_r($result);


} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
