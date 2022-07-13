<?php declare(strict_types=1);

namespace Janfish\EOffice;

use RuntimeException;
use Janfish\EOffice\Biz\BizTrait;

/**
 * Class Server
 * @author Robert
 * @package Janfish\EOffice
 * @method \Janfish\EOffice\Biz\Flow getFlow()
 * @method \Janfish\EOffice\Biz\Department getDepartment()
 * @method \Janfish\EOffice\Biz\User getUser()
 */
class SDK
{

    use BizTrait;

    /**
     * @var array
     */
    private $config;

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
     * @param string $className
     * @param array $config
     * @return mixed
     */
    static private function getInstance(string $className, array $config = [])
    {
        if (!class_exists($className)) {
            throw new RuntimeException('class not exist');
        }
        if (!isset(self::$_remote[$className])) {
            self::$_remote[$className] = new $className($config);
        }
        return self::$_remote[$className];
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        if (!preg_match('/^get([\w]+)$/', $method, $matches)) {
            throw new \RuntimeException('method is not exist');
        }
        $className = sprintf("\Janfish\EOffice\Biz\%s", $matches[1]);
        return (self::getInstance($className))->setClient(self::getInstance('\Janfish\EOffice\Utils\Remote', $this->config));
    }

}