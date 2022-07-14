<?php declare(strict_types=1);

namespace Janfish\EOffice\Biz;

use Janfish\EOffice\Exception\BizException;

/**
 * Class Flow
 * @author Robert
 * @package Janfish\EOffice\Biz
 */
class Flow
{
    use BizTrait;

    /**
     * 创建流程
     * @param int $flowId
     * @param string $flowName
     * @param string $flowContent
     * @param array $formData
     * @param string $type
     * @param int|null $emergencyType
     * @param string $agentType
     * @return array
     * @throws
     */
    public function create(
        int $flowId,
        string $flowName,
        string $flowContent,
        array $formData = [],
        string $type = '',
        int $emergencyType = null,
        string $agentType = ''
    ): array {
        return $this->remote->call('post', 'api/flow/new-page/flow-save', [
            'flow_id' => $flowId,
            'flow_run_name' => $flowName,
            'run_name_html' => $flowContent,
            'form_data' => $formData,
            'create_type' => $type,
            'instancy_type' => $emergencyType,
            'agentType' => $agentType,
        ]);
    }


    /**
     * 保存流程信息
     * @param int $runId
     * @param int $flowProcess
     * @param array $formData
     * @param int|null $runSeq
     * @param string $flowName
     * @param string $flowContent
     * @param string $type
     * @return array
     * @throws BizException
     */
    public function save(
        int $runId,
        int $flowProcess,
        string $flowName = '',
        string $flowContent = '',
        array $formData = [],
        int $runSeq = null,
        string $type = ''
    ): array {
        $reqData = [
            'run_id' => $runId,
            'flow_process' => $flowProcess,
            'run_seq' => $runSeq,
            'create_type' => $type,
            'form_data' => $formData,
        ];
        if ($flowName) {
            $reqData['run_name'] = $flowName;
        }
        if ($flowContent) {
            $reqData['run_name_html'] = $flowContent;
        }
        return $this->remote->call('post', 'api/flow/run/save-flow-run-info', $reqData);
    }

    /**
     * @param int $runId
     * @param int $processId
     * @param int $flowRunProcessId
     * @param string $processHostUser 主办人用户ID，主办人只有一个
     * @param string $processTransactUser 办理人用户ID，逗号拼接的字符串，如果没有经办人，传空字符串或者跟主办人的值一致即可
     * @param int|null $flowProcess
     * @param int|null $nextFlowProcess
     * @param string $processCopyUser
     * @param array $sonFlowInfo
     * @param string $flowTurnType
     * @return mixed
     * @throws BizException
     */
    public function submit(
        int $runId,
        int $processId,
        int $flowRunProcessId,
        string $processHostUser,
        string $processTransactUser,
        int $flowProcess = null,
        int $nextFlowProcess = null,
        string $processCopyUser = '',
        array $sonFlowInfo = [],
        string $flowTurnType = ''
    ) {
        $reqData = [
            'run_id' => $runId,
            'process_id' => $processId,
            'flow_run_process_id' => $flowRunProcessId,
            'process_host_user' => $processHostUser,
            'process_transact_user' => $processTransactUser,
            'next_flow_process' => $nextFlowProcess,
            'process_copy_user' => $processCopyUser,
            'sonFlowInfo' => $sonFlowInfo,
            'flowTurnType' => $flowTurnType,
        ];
        if ($flowProcess) {
            $reqData['flow_process'] = $flowProcess;
        }
        return $this->remote->call('post', 'api/flow/run/flow-turning', $reqData);
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param int $startPage
     * @param array $sort
     * @param array $search
     * @param int|null $formId
     * @param array $formExportParams
     * @param array $formSearchParams
     * @param bool $withDetail
     * @return array
     * @throws BizException
     */
    public function list(
        int $page = 1,
        int $pageSize = 20,
        int $startPage = 1,
        array $sort = [],
        array $search = [],
        int $formId = null,
        array $formExportParams = [],
        array $formSearchParams = [],
        bool $withDetail = true
    ): array {
        $reqData = [
            'form_id' => $formId,
            'autoFixPage' => $startPage,
            'page' => $page,
            'limit' => $pageSize,
        ];
        if ($search) {
            $reqData['search'] = json_encode($search);
        }
        if ($formExportParams) {
            $reqData['formExportParams'] = json_encode($formExportParams);
        }
        if ($formSearchParams) {
            $reqData['formSearchParams'] = json_encode($formSearchParams);
        }
        if ($sort) {
            $reqData['order_by'] = json_encode($sort);
        }
        if ($withDetail) {
            $reqData['flow_module_factory'] = 1;
        }
        return $this->remote->call('get', 'api/flow/flow-list/flow-search-list', $reqData);
    }


    /**
     * @param int $page
     * @param int $pageSize
     * @param int $startPage
     * @param array $sort
     * @param array $search
     * @return array
     * @throws BizException
     */
    public function finishedList(
        int $page = 1,
        int $pageSize = 20,
        int $startPage = 1,
        array $sort = [],
        array $search = []): array
    {
        $reqData = [
            'autoFixPage' => $startPage,
            'page' => $page,
            'limit' => $pageSize,
        ];
        if ($sort) {
            $reqData['order_by'] = json_encode($sort);
        }
        if ($search) {
            $reqData['search'] = json_encode($search);
        }
        return $this->remote->call('get', 'api/flow/flow-list/finished-list', $reqData);
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param int $startPage
     * @param array $sort
     * @param array $search
     * @return array
     * @throws BizException
     */
    public function todoList(
        int $page = 1,
        int $pageSize = 20,
        int $startPage = 1,
        array $sort = [],
        array $search = []): array
    {
        $reqData = [
            'autoFixPage' => $startPage,
            'page' => $page,
            'limit' => $pageSize,
        ];
        if ($sort) {
            $reqData['order_by'] = json_encode($sort);
        }
        if ($search) {
            $reqData['search'] = json_encode($search);
        }
        return $this->remote->call('get', 'api/flow/flow-list/teed-to-do-list', $reqData);
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param int $startPage
     * @param array $sort
     * @param array $search
     * @return array
     * @throws BizException
     */
    public function doneList(
        int $page = 1,
        int $pageSize = 20,
        int $startPage = 1,
        array $sort = [],
        array $search = []): array
    {
        $reqData = [
            'autoFixPage' => $startPage,
            'page' => $page,
            'limit' => $pageSize,
        ];
        if ($sort) {
            $reqData['order_by'] = json_encode($sort);
        }
        if ($search) {
            $reqData['search'] = json_encode($search);
        }
        return $this->remote->call('get', 'api/flow/flow-list/already-do-list', $reqData);
    }


}