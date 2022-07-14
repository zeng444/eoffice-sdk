#### 提交审核单

```
<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Janfish\EOffice\SDK as EOfficeSDK;


const FLOW_ID = 50; //流程模板ID，这个写死，id50为“业务支付申请”表
const FLOW_PROCESS_ID = 1; //流程步骤ID
const FLOW_START_PROCESS_ID = 189; //初始流程节点ID
const FLOW_NEXT_PROCESS_ID = 190;//提交流程节点ID
const FLOW_PROCESS_HOST = 'WV00000002';//主办人ID，此处使用userId，来自User()->list接口

try {

    $config = [
        'apiPrefix' => 'http://192.168.10.242:8010/eoffice10/server/public/',
        'agentId' => '100001',
        'secret' => 'B771nF3FqMCJuaUuv74AhcfXwp5hia7o',
        'user' => 'zengweiqi',
    ];
    $client = new EOfficeSDK($config);

    $form = [
        //表头标题，参考“公司”选择器
        'DATA_86' => "1", //选项标识
        'DATA_86_TEXT' => "成都市云瑞铭博企业管理有限公司", //选项值

        //申请日期
        'DATA_100' => "2022-07-13",

        //招标人，参考“公司”选择器
        'DATA_87' => "3",//选项标识
        'DATA_87_TEXT' => "四川鸿运欣智科技有限公司",//选项值

        //招标人性质，参考“招标人性质”选择器
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

                //支付方式，参考“支付方式”选择器
                'DATA_101_5' => "1",  //选项标识
                'DATA_101_5_TEXT' => "现金", //选项值

                'DATA_101_7' => "四川支行", //开户行
                'DATA_101_8' => 21, //平台支付金额
                'DATA_101_9' => "2022-07-13", //要求付款时间
                'DATA_101_10' => "2022-07-14", //收款时间
            ]
        ],
        'DATA_102' => "21", //平台支付总金额（小写），需要自动计算明细（DATA_101节点下DATA_101_8值的和）计算总额
        'DATA_103' => "21", //平台支付总金额（大写）,写的和DATA_102一样即可
        'DATA_101_8_amount' => "21", //汇总即可（可以不填写）
        'DATA_81' => "备注", //备注
        'DATA_96' => "zengweiqi", //申请人
        'DATA_97' => "",//财务审核（创建不填写）
        'DATA_98' => "",//财务主管审核（创建不填写）
        'DATA_99' => "",//负责人审核（创建不填写）
    ];

    //流程标题
    $flowTitle = "Robert的业务支付申请";
    //必须包裹div否则会创建失败
    $content = '<div><h3>' . $flowTitle . '</h3></div>';

    //创建流程
    $result = $client->getFlow()->create(FLOW_ID, $flowTitle, $content, $form);

    print_r($result);

    $run_id = $result['run_id'];
    $flowRunProcessId = $result['flow_run_process_id'];

    $result = $client->getFlow()->submit($run_id, FLOW_PROCESS_ID, $flowRunProcessId, FLOW_PROCESS_HOST, '',FLOW_START_PROCESS_ID, FLOW_NEXT_PROCESS_ID, '', [], 'turn');

    print_r($result);


} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}


```

#### 查询已通过审核单

```
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
    $list = $client->getFlow()->finishedList(1, 1, 1, [], [
        "run_id" => [223],
        "flow_id" => [50],
    ]);
    print_r($list);

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

```

#### 选择器标识项字典

- 公司选择器

| 标识              | 项目  |
|-----------------|-----|
| 成都市云瑞铭博企业管理有限公司 | 1   |
| 成都市欣誉文化传媒有限公司   | 2   |
| 四川鸿运欣智科技有限公司                | 3   |
|  成都劲芫商务服务有限公司               | 4   |
|  成都市荀洋商务服务有限公司               | 5   |
| 成都楠延建筑装饰工程有限公司                | 6   |
|   成都拓瑞恒科技有限公司              | 7   |
| 成都梓砼信息技术有限公司                | 8   |
|  四川领晟人力资源服务有限公司               | 9   |
| 成都远芮商务信息咨询服务有限公司                | 10  |
| 成都长红睿广告传媒有限公司                | 11  |

- 招标人性质

| 标识              | 项目  |
|-----------------|-----|
| 一般纳税人 | 1   |
| 小规模纳税人 | 2   |

- 支付方式

| 标识              | 项目  |
|-----------------|-----|
| 现金 | 1   |
| 银行转账 | 2   |
| 支票 | 3   |