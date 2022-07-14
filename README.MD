## EOffice Open API SDK

#### Reference

```
use Janfish\EOffice\SDK as EOfficeSDK;

try {
    $config = [
        'apiPrefix' => 'http://192.168.10.242:8010/eoffice10/server/public/',
        'agentId' => '100001',
        'secret' => 'B771nF3FqMCJuaUuv74AhcfXwp5hia7o',
        'user' => 'zengweiqi',
        'timeout' => 30,
    ];
    $sdk = new EOfficeSDK($config);
    $response = $sdk->getDepartment()->tree();
    print_r($response);

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

```

#### Method List

```
use Janfish\EOffice\Client as EOfficeClient;

try {
    $config = [
        'apiPrefix' => 'http://192.168.10.242:8010/eoffice10/server/public/',
        'agentId' => '100001',
        'secret' => 'B771nF3FqMCJuaUuv74AhcfXwp5hia7o',
        'user' => 'zengweiqi',
        'timeout' => 30,
    ];
    $sdk = new EOfficeSDK($config);
    
    $departmentList = $sdk->getDepartment()->tree;
    
    $userToken = $sdk->getUser()->getToken();
    $userList = $sdk->getUser()->list();
    
    $flowlist = $sdk->getFlow()->list();
    $flowToDolist = $sdk->getFlow()->todoList();
    $flowDonelist = $sdk->getFlow()->doneList();
    $flowFinishedlist = $sdk->getFlow()->finishedList();

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

```