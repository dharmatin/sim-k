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

  public function resetPassword() {
    $service = new AuthService();
    $userInfo = $this->getUserInfo();
    if ($userInfo->userGroup->id == $this->config::read("constant.USER_GROUP.SUPER_USER")) {
      $request = $this->request->getJsonRawBody();
      $response = $service->reset($request->email);
      if ($response["code"] == $this->config::read("constant.SUCCESS")) {
        return $this->successResponse($response["message"]);
      }
      return $this->errorResponse($response["code"], $response["message"]);
    }
    return $this->errorResponse($this->config::read("constant.ERR_UNAUTHORIZED"), $this->translator::translate("error_message.error_403"));
  }

  public function updateUser() {
    $service = new AuthService();
    $userInfo = $this->getUserInfo();
    if ($userInfo) {
      $request = $this->request->getJsonRawBody();
      foreach($request as $key=>$value) {
        $userInfo->{$key} = $value;
      }
      $response = $service->updateProfile(TypeHelper::cast(new \Dharmatin\Simk\Model\Data\User, $userInfo));
      if ($response["code"] == $this->config::read("constant.SUCCESS")) {
        return $this->successResponse($response["message"]);
      }

      return $this->errorResponse($response["code"], $response["message"]);
    }
    return $this->errorResponse($this->config::read("constant.ERR_UNAUTHORIZED"), $this->translator::translate("error_message.error_403"));
  }

  public function changeStatus() {
    $service = new AuthService();
    if ($this->getUserInfo()) {
      $request = $this->request->getJsonRawBody();
      $response = $service->updateProfile(TypeHelper::cast(new \Dharmatin\Simk\Model\Data\User, $request));
      if ($response["code"] == $this->config::read("constant.SUCCESS")) {
        return $this->successResponse($response["message"]);
      }

      return $this->errorResponse($response["code"], $response["message"]);
    }
    return $this->errorResponse($this->config::read("constant.ERR_UNAUTHORIZED"), $this->translator::translate("error_message.error_403"));
  }

  private function getUserInfo() {
    $service = new AuthService();
    $token = $this->request->getHeaders("authorization");
    return $service->getTokenInformation($token)->data;
  }
}