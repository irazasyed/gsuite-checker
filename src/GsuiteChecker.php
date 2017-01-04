<?php

namespace Irazasyed\GsuiteChecker;

use Generator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GsuiteChecker.
 */
class GsuiteChecker
{
    /** @var array The domains */
    protected $domains = [];

    /** @var null|Client */
    protected $httpClient = null;

    /** @var int Pool Concurrency. Default: 25 */
    protected $concurrency = 25;

    /** @var int Connection Timeout. Default: 5 seconds */
    protected $connectTimeout = 5;

    /**
     * Create a new instance of GsuiteChecker with provided domains.
     *
     * @param mixed $domains
     */
    public function __construct($domains = [])
    {
        $this->domains = (array) $domains;
    }

    /**
     * Create a new instance if the value isn't one already.
     *
     * @param mixed $domains
     *
     * @return static
     */
    public static function make($domains = [])
    {
        return new static($domains);
    }

    /**
     * Check whether the domain(s) have a Google Suite account associated with them.
     *
     * @return $this
     */
    public function check()
    {
        Promise\each_limit(
            $this->getPromises(),
            $this->concurrency,
            [$this, 'responseHandler'],
            [$this, 'responseHandler']
        )->wait();

        return $this;
    }

    /**
     * Get all promises.
     *
     * @return Generator
     */
    protected function getPromises()
    {
        foreach ($this->domains as $domain) {
            $uri = "https://www.google.com/a/{$domain}/ServiceLogin?https://docs.google.com/a/{$domain}";

            yield $this->getHttpClient()->requestAsync('GET', $uri);
        }
    }

    /**
     * Get HTTP Client.
     *
     * @return Client
     */
    protected function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->httpClient = new Client([
                'connect_timeout' => $this->connectTimeout,
                'headers'         => [
                    'User-Agent' => $this->defaultUA(),
                ],
            ]);
        }

        return $this->httpClient;
    }

    /**
     * Default User Agent.
     *
     * @return string
     */
    protected function defaultUA()
    {
        return 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36';
    }

    /**
     * Get all of the domains.
     *
     * @return array
     */
    public function all()
    {
        return $this->domains;
    }

    /**
     * Handle Response and Update Status of Domains.
     *
     * @param ResponseInterface|RequestException $response
     * @param                                    $index
     */
    public function responseHandler($response, $index)
    {
        /** @var string $domain Get the domain */
        $domain = $this->domains[$index];

        /* Remove it from the list */
        unset($this->domains[$index]);

        /** @var $status Gsuite status of the domain */
        $status = $this->status($response);

        /* Put the domain and status to the list */
        $this->domains[$domain] = $status;
    }

    /**
     * Determine status of GSuite based on response body.
     *
     * @param ResponseInterface|RequestException $response
     *
     * @return int
     */
    protected function status($response)
    {
        if ($response instanceof RequestException) {
            return -1;
        }

        return $this->strContains($response->getBody(), 'Server error') ? 0 : 1;
    }

    /**
     * Determine if a given string contains a given substring.
     *
     * @param string       $haystack
     * @param string|array $needles
     *
     * @return bool
     */
    protected function strContains($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }
}
