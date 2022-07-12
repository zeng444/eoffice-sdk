## EOffice Open API SDK

#### Reference

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
    $client = new EOfficeClient($config);
    $response = $client->getDepartment()->tree();
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
    $client = new EOfficeClient($config);
    $department = $client->getDepartment();
    $user = $client->getUser();
    $flow = $client->getFlow();


} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

```