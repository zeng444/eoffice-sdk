<?php declare(strict_types=1);

namespace Janfish\EOffice\Biz;

use Janfish\EOffice\Exception\BizException;

/**
 * Class User
 * @author Robert
 * @package Janfish\EOffice\Biz
 */
class User
{

    use BizTrait;

    /**
     * @param string $agentId
     * @param string $secret
     * @param string $user
     * @return array
     * @throws BizException
     */
    public function getToken(string $agentId, string $secret, string $user): array
    {
        return $this->remote->call('post', 'api/open-api/get-token', [
            'agent_id' => $agentId,
            'secret' => $secret,
            'user' => $user,
        ]);
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param array $sort
     * @param string $search
     * @param int $startPage
     * @return array
     * @throws BizException
     */
    public function list(int $page = 1, int $pageSize = 20, array $sort = [], string $search = '', int $startPage = 1)
    {
        return $this->remote->call('post', 'api/user/users', [
            'autoFixPage' => $startPage,
            'limit' => $pageSize,
            'order_by' => json_encode($sort),
            'page' => $page,
            'search' => $search,
        ]);
    }

}