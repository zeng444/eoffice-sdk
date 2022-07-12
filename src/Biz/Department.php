<?php declare(strict_types=1);

namespace Janfish\EOffice\Biz;

/**
 * Class Server
 * @author Robert
 * @package Janfish\EOffice\Biz
 */
class Department
{

    use BizTrait;

    /**
     * 部门列表
     * @return array
     */
    public function tree(): array
    {
        return $this->remote->call('get', 'api/system/department/all-tree');
    }
}