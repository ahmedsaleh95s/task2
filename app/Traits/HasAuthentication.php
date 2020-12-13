<?php

namespace App\Traits;

use Psr\Http\Message\ServerRequestInterface;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Passport;

trait HasAuthentication
{

        public function tokenRequest(ServerRequestInterface $serverRequest, array $data, $provider=null)
        {
                $body = $this->getAuthTokenBodyRequest($data, $provider);
                $request = $serverRequest->withParsedBody($body);
                $response =  app(AccessTokenController::class)->issueToken($request);
                $data['statusCode'] = $response->getStatusCode();
                $data['response'] =  $response->getContent();
                return $data;
        }

        private function getAuthTokenBodyRequest($data, $provider)
        {
                $auth = $this->getClientAuth($provider);
                $data['client_secret'] = $auth['secret'];
                $data['client_id'] = $auth['id'];
                $data['username'] = $data['email'];
                $data['grant_type'] = "password";
                return $data;
        }

        private function getClientAuth($provider)
        {
                return ($provider) ?  
                Passport::client()->where('password_client', true)->where('provider', $provider)->first():
                Passport::client()->where('password_client', true)->first() ;
        }
}
