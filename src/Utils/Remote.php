<?php declare(strict_types=1);

namespace Janfish\EOffice\Utils;

use Janfish\EOffice\Biz\User;
use Janfish\EOffice\Exception\BizException;
use RuntimeException;

/**
 * Class Server
 * @author Robert
 * @package Janfish\EOffice\Utils
 */
class Remote
{

    /**
     * @var int
     */
    private $timeout = 30;

    /**
     * @var
     */
    private $agentId;

    /**cd
     * @var
     */
    private $secret;

    /**
     * @var
     */
    private $user;


    /**
     * @var string
     */
    private $apiPrefix = 'http://192.168.10.242:8010/eoffice10/server/public/';

    /**
     * @var string[]
     */
    private $authExceptedPath = ['api/open-api/get-token'];

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (isset($options['apiPrefix'])) {
            $this->apiPrefix = $options['apiPrefix'];
        }
        if (isset($options['timeout'])) {
            $this->timeout = $options['timeout'];
        }
        if (isset($options['agentId'])) {
            $this->agentId = $options['agentId'];
        }
        if (isset($options['secret'])) {
            $this->secret = $options['secret'];
        }
        if (isset($options['user'])) {
            $this->user = $options['user'];
        }
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $data
     * @return mixed
     * @throws BizException
     */
    public function call(string $method, string $path, array $data = [])
    {
        $method = sprintf('http%s', ucfirst($method));
        $result = $this->$method($this->apiPrefix . $path, http_build_query($data), [
            'Authorization: Bearer ' . (in_array($path, $this->authExceptedPath) ? '' : $this->getToken($this->agentId,
                $this->secret, $this->user))
        ]);
        if (!$result || !$response = json_decode($result, true)) {
            throw new BizException('Response error');
        }
        if (!isset($response['status']) || $response['status'] == 0) {
            $error = current($response['errors']);
            throw new BizException($error['message'], (int)$error['code']);
        }
        return $response['data'];
    }

    /**
     * @param string $agentId
     * @param string $secret
     * @param string $user
     * @return string
     * @throws BizException
     */
    public function getToken(string $agentId, string $secret, string $user): string
    {
        $tempFile = sys_get_temp_dir() . '/' . md5($agentId . '-' . $user);
        if (file_exists($tempFile)) {
            $response = json_decode(file_get_contents($tempFile), true);
            if (time() < $response['expired_at'] - 120) {
                return $response['token'];
            }
        }
        $response = (new User())->setClient($this)->getToken($agentId, $secret, $user);
        $response['expired_at'] = time() + $response['expired_in'];
        @file_put_contents($tempFile, json_encode($response));
        return $response['token'];
    }


    /**
     * @param string $uri
     * @param string $data
     * @param array $headers
     * @return string
     */
    private function httpPost(string $uri, string $data, array $headers = []): string
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $uri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $headers,
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            throw new RuntimeException('Http post error:' . $err);
        }
        if (!$response) {
            throw new RuntimeException('Response is empty');
        }
        return $response;
    }

    /**
     * @param string $uri
     * @param string $data
     * @param array $headers
     * @return string
     */
    private function httpGet(string $uri, string $data, array $headers = []): string
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $uri . ($data ? '?' . $data : ''),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => $headers,
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            throw new RuntimeException('Http get error:' . $err);
        }
        if (!$response) {
            throw new RuntimeException('Response is empty');
        }
        return $response;
    }

}