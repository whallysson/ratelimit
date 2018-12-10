<?php

namespace CodeBlog\RateLimit;

/**
 * Class CodeBlog RateLimit
 *
 * @author Whallysson Avelino <https://github.com/whallysson>
 * @package CodeBlog\RateLimit
 */
class RateLimit extends VariableCache {

    /**
     * Requests for hours
     * @var type interger
     */
    private $maxResquests = 100;
    private $timeReset = 3600; // 01h

    public function __construct(string $cacheFolder, string $key, int $max = null, $reset = null) {
        parent::__construct($cacheFolder);
        $this->maxResquests = (int)($max ? $max : $this->maxResquests);
        $this->timeReset = ($reset ? $reset : $this->timeReset);

        $this->call($key);
    }

    public function call($key) {
        if ($key) {

            $data = $this->fetch($key);
            if (false === $data) {

                // First time or previous perion expired,
                // initialize and save a new entry
                $remaining = $this->maxResquests - 1;
                $variables = [
                    'remaining' => $remaining,
                    'created' => time(),
                ];
                $reset = $this->timeReset;

                $this->store($key, $variables, $this->timeReset);
            } else {
                // Take the current entry and update it
                $remaining = ((--$data['remaining'] >= 0) ? $data['remaining'] : -1);
                $variables = [
                    'remaining' => $remaining,
                    'created' => $data['created'],
                ];
                $reset = (($data['created'] + $this->timeReset) - time());

                $this->store($key, $variables, $reset);
            }

            // Set rating headers
            $this->addHeaders('X-Rate-Limit-Limit', $this->maxResquests);
            $this->addHeaders('X-Rate-Limit-Reset', $reset);
            $this->addHeaders('X-Rate-Limit-Remaining', $remaining);

            // Check if the current key is allowed to pass
            if ($remaining < 0) {
                // Rewrite remaining headers
                $this->addHeaders('X-Rate-Limit-Remaining', 0);

                // Exits with status "429 Too Many Requests" (see doc below)
                $this->fail();
            }
        } else {
            // Exits with status "429 Too Many Requests" (see doc below)
            $this->fail();
        }
    }

    protected function addHeaders($headers, $value) {
        header("{$headers}: {$value}");
    }

    /**
     * Exits with status "429 Too Many Requests"
     *
     * Work around on Apache's issue: it does not support
     * status code 429 until version 2.4
     *
     * @link http://stackoverflow.com/questions/17735514/php-apache-silently-converting-http-429-and-others-to-500
     */
    protected function fail() {
        http_response_code(429);
        header('HTTP/1.1 429 Too Many Requests', false, 429);

        // Write the remaining headers
        foreach (getallheaders() as $key => $value) {
            $this->addHeaders($key, $value);
        }

        throw new \Exception('Too Many Requests. Rate limit reached');
    }

}
