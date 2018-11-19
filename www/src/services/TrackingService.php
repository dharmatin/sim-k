<?php

namespace Dharmatin\Simk\Service;

use Dharmatin\Simk\Model\UserLoginHistory;

class TrackingService {
  public function addLoginTracking($username, $response) {
     $userLoginHistory = new UserLoginHistory();
     $userLoginHistory->save($username, $response);
  }
  public function addActivityTracking($user) {

  }
}