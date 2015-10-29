<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Log;

/**
 * The Log log executions, message and errors.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class Log {

    private static $instance = null;
    private $startTime            = null;
    private $finishTime           = null;
    private $elapsedTimeFromStart = 0.0;
    private $identifier           = null;

    private function __construct() {}
    private function __clone() {}

    /**
     *
     * @return Log
     */
    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new Log;
        }
        return self::$instance;
    }

    /**
     *
     * @param string $message
     */
    public function log($message) {
        $this->elapsedTime();
        $this->generateIdentifier();
        $message = '[ID: '.$this->identifier.'] [TIME: '.$this->finishTime.'] [ELAPSED: '.$this->elapsedTimeFromStart.']'. $message.PHP_EOL;
        error_log($message, 3, __DIR__.'/../../.log/execution_log.txt');
    }

    /**
     * Calculated the different time of the log line.
     */
    public function elapsedTime() {
        $currentTime = microtime(true);
        if ($this->startTime === null) {
            $this->startTime            = $currentTime;
            $this->finishTime           = $currentTime;
        } else {
            $this->finishTime           = $currentTime;
            $this->elapsedTimeFromStart = $currentTime - $this->startTime;
        }
    }

    /**
     * Generate a unique identifier to filter the executions.
     */
    private function generateIdentifier() {
        if ($this->identifier === null) {
            $this->identifier = time();
        }
    }
}
