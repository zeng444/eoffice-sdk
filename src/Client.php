<?php declare(strict_types=1);

namespace Janfish\EOffice;

use RuntimeException;
use Janfish\EOffice\Biz\BizTrait;
use Janfish\EOffice\Utils\Remote;

/**
 * Class Server
 * @author Robert
 * @package Janfish\EOffice
 * @method \Janfish\EOffice\Biz\Flow getFlow()
 * @method \Janfish\EOffice\Biz\Department getDepartment()
 * @method \Janfish\EOffice\Biz\User getUser()
 */
class Client
{

    use BizTrait;

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var
     */
    private static $_remote;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->config = $options;
    }

    /**
     * @param array $config
     * @return Remote
     */
    static private function getRemote(array $config): Remote
    {
        if (!self::$_remote) {
            self::$_remote = new Remote($config);
        }
        return self::$_remote;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        if (!preg_match('/get([\w]+)/', $method, $matches)) {
            throw new \RuntimeException('method is not exist');
        }
        $className = sprintf("\Janfish\EOffice\Biz\%s", $matches[1]);
        if (!class_exists($className)) {
            throw new RuntimeException('class not exist');
        }
        return (new $className)->setClient(self::getRemote($this->config));
    }

}