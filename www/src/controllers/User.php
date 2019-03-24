<?php

namespace Dharmatin\Simk\Controller;

use Dharmatin\Simk\Service\AuthService;
use Dharmatin\Simk\Service\TrackingService;
use Dharmatin\Simk\Library\Translator;
use Dharmatin\Simk\Helper\TypeHelper;
use Dharmatin\Simk\Model\Request\Register;

class User extends AppController {

  public function login() {
    $service = new AuthService();
    $tracking = new TrackingService();
    $request =  $this->request->getJsonRawBody();
    $loggedInResponse = $service->login($request->username, $request->password);
    $tracking->addLoginTracking($request->username, $loggedInResponse);
    if ($loggedInResponse["code"] == $this->config::read("constant.SUCCESS")) 
      return $this->successResponse(Translator::translate("login.success"), $loggedInResponse["token"]);
    
    return $this->errorResponse($loggedInResponse["code"], $loggedInResponse["message"]);
  }

  public function register() {
    $service = new AuthService();
    $response = $service->register(TypeHelper::cast(new Register, $this->request->getJsonRawBody()));
    if ($response["code"] == $this->config::read("constant.SUCCESS"))
      return $this->successResponse($response["message"]);

    return $this->errorResponse($response["code"], $response["message"]);
  }
}