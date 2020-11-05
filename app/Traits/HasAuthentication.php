<?php

namespace App\Traits;

use Psr\Http\Message\ServerRequestInterface;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Passport;

trait HasAuthentication
{

        public function tokenRequest(ServerRequestInterface $serverRequest, array $data)
        {
                $body = $this->getAuthTokenBodyRequest($data);
                $request = $serverRequest->withParsedBody($body);
                $response =  app(AccessTokenController::class)->issueToken($request);
                $data['statusCode'] = $response->getStatusCode();
                $data['response'] =  $response->getContent();
                return $data;
        }

        private function getAuthTokenBodyRequest($data)
        {
                $auth = Passport::client()->where('password_client', 1)->first();
                $data['client_secret'] = $auth['secret'];
                $data['client_id'] = $auth['id'];
                $data['username'] = $data['email'];
                $data['grant_type'] = "password";
                return $data;
        }
}
