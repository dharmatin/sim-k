<?php

namespace Dharmatin\Simk\Controller;

use Dharmatin\Simk\Service\AuthService;
use Dharmatin\Simk\Service\TrackingService;
use Dharmatin\Simk\Library\Translation;

class User extends AppController {

  public function login() {
    $service = new AuthService();
    $tracking = new TrackingService();
    $request =  $this->request->getJsonRawBody();
    $loggedInResponse = $service->login($request->username, $request->password);
    $tracking->addLoginTracking($request->username, $loggedInResponse);
    if ($loggedInResponse["code"] == $this->config::read("constant.SUCCESS")) 
      return $this->successResponse(Translation::translate("login.success"), $loggedInResponse["token"]);
    
    return $this->errorResponse($loggedInResponse["code"], $loggedInResponse["message"]);
  }

  public function register() {
    $service = new AuthService();
  }
}