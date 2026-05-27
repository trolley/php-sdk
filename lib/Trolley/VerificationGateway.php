<?php
namespace Trolley;

class VerificationGateway
{
    private $_gateway;
    private $_config;
    private $_http;

    public function __construct($gateway)
    {
        $this->_gateway = $gateway;
        $this->_config = $gateway->config;
        $this->_config->assertHasAccessTokenOrKeys();
        $this->_http = new Http($gateway->config);
    }

    public function search($query = [])
    {
        $response = $this->_http->get('/v1/verifications', $query);
        return $this->buildCollection($response, $query);
    }

    public function expire($body)
    {
        $response = $this->_http->patch('/v1/verifications/expire', $body);
        return $this->buildCollection($response);
    }

    public function trigger($verificationType, $body)
    {
        $response = $this->_http->post("/v1/verifications/{$verificationType}/trigger", $body);
        return $this->buildCollection($response);
    }

    public function triggerWatchlist($body)
    {
        $response = $this->_http->post('/v1/verifications/watchlist/trigger', $body);
        return $this->buildCollection($response);
    }

    public function trigger_watchlist($body)
    {
        return $this->triggerWatchlist($body);
    }

    private function buildCollection($response, $query = null)
    {
        if ($response['ok']) {
            $pager = $query === null ? [] : [
                'object' => $this,
                'method' => 'search',
                'methodArgs' => $query
            ];

            return new ResourceCollection($response, $response['verifications'], $pager);
        } else if ($response['errors']) {
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }
}

class_alias('Trolley\VerificationGateway', 'Trolley_VerificationGateway');
