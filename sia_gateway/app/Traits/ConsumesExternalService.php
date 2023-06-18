<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

trait ConsumesExternalService
{
    /**
     * Send a request to any service
     * @return mixed
     */
    public function performRequest($method, $requestUrl, $form_params = [], $headers = [])
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        if(isset($this->secret)) {
            $headers['Authorization'] = $this->secret;
        }

        try {
            $response = $client->request($method, $requestUrl, ['form_params' => $form_params, 'headers' => $headers]);
            return $this->handleResponse($response);
        } catch (ClientException $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * Handle the successful response
     * @return mixed
     */
    private function handleResponse(ResponseInterface $response)
    {
        $content = $response->getBody()->getContents();
        return json_decode($content, true);
    }

    /**
     * Handle the exception and return the error response
     * @return mixed
     */
    private function handleException(ClientException $exception)
    {
        $response = $exception->getResponse();
        $statusCode = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        ob_clean(); // Remove any existing output buffering

        http_response_code($statusCode);
        header('Content-Type: application/json');

        echo $content;
        exit;
    }
}
