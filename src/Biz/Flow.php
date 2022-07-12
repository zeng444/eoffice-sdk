<?php declare(strict_types=1);

namespace Janfish\EOffice\Biz;

/**
 * Class Server
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
     * @param string $type
     * @return array
     */
    public function save(
        int $runId,
        int $flowProcess,
        array $formData = [],
        int $runSeq = null,
        string $flowName = '',
        string $type = ''
    ): array {
        return $this->remote->call('post', 'api/flow/run/save-flow-run-info', [
            'run_id' => $runId,
            'flow_process' => $flowProcess,
            'run_seq' => $runSeq,
            'run_name' => $flowName,
            'create_type' => $type,
            'form_data' => $formData,
        ]);
    }

    /**
     * @param int $runId
     * @param int $processId
     * @param string $processHostUser
     * @param string $processTransactUser
     * @param int|null $nextFlowProcess
     * @param int|null $flowProcess
     * @param string $processCopyUser
     * @param array $sonFlowInfo
     * @param string $flowTurnType
     * @return array
     */
    public function submit(
        int $runId,
        int $processId,
        string $processHostUser,
        string $processTransactUser,
        int $nextFlowProcess =null,
        int $flowProcess =null ,
        string $processCopyUser = '',
        array $sonFlowInfo = [],
        string $flowTurnType = ''
    ): array {
        return $this->remote->call('post', 'api/flow/run/save-flow-run-info', [
            'run_id' => $runId,
            'process_id' => $processId,
            'process_host_user' => $processHostUser,
            'process_transact_user' => $processTransactUser,
            'next_flow_process' => $nextFlowProcess,
            'flow_process' => $flowProcess,
            'process_copy_user' => $processCopyUser,
            'sonFlowInfo' => $sonFlowInfo,
            'flowTurnType' => $flowTurnType,
        ]);
    }


    /**
     * @param string $agentId
     * @param string $secret
     * @param string $user
     * @return array
     */
    public function getToken(string $agentId, string $secret, string $user): array
    {
        return $this->remote->call('post', 'api/flow/run/flow-turning', [
            'agent_id' => $agentId,
            'secret' => $secret,
            'user' => $user,
        ]);
    }

}