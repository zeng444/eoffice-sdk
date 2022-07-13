<?php declare(strict_types=1);

namespace Janfish\EOffice\Biz;

use Janfish\EOffice\Utils\Remote;

/**
 * @author Robert
 * @package Janfish\EOffice\Biz
 */
trait BizTrait
{

    /**
     * @var Remote
     */
    private $remote;

    /**
     * @param Remote $remote
     * @return $this
     */
    public function setClient(Remote $remote): self
    {
        $this->remote = $remote;
        return $this;
    }

    /**
     * @return Remote
     */
    public function getClient(): Remote
    {
        return $this->remote;
    }
}