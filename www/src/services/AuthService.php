<?php

namespace Dharmatin\Simk\Service;

use Dharmatin\Simk\Model\Users;
use Dharmatin\Simk\Core\Configure;
use Dharmatin\Simk\Helper\StringHelper;
use Dharmatin\Simk\Library\Translator;
use Dharmatin\Simk\Library\Memcached;
use Dharmatin\Simk\Model\Request\Register;
use Firebase\JWT\JWT;
use Dharmatin\Simk\Model\Data\User;

class AuthService {
  
  const LOGIN_ATEMPT_INTERVAL = 300;
  const MAX_LOGIN_ATEMPT = 3;
  const LOGIN_ATEMPT_KEY = "login:atempt:{username}";
  const GENERATED_PASSWORD_LENGTH = 8;

  private $user;
  private $cacheKey;
  private $cache;

  public function __construct() {
    $this->cache = new Memcached();
  }

  public function login($username, $password) {
    $this->setLoginAttemptCacheKey($username);
    if ($this->getLoginAttempt() >= self::MAX_LOGIN_ATEMPT) {
      return array(
        "code" => Configure::read("constant.ERR_UNAUTHORIZED"), 
        "message" => Translator::translate("login.maximum_attempt")
      );
    }

    $user = $this->getUserByUsername($username);

    if (!$user) {
      $this->addLoginAttempt($username);
      return array(
        "code" => Configure::read("constant.ERR_UNAUTHORIZED"), 
        "message" => Translator::translate("login.unauthorized_username")
      );
    }

    if (!$this->isVerifiedPassword($user, $password)) {
      $this->addLoginAttempt($username);
      return array(
        "code" => Configure::read("constant.ERR_UNAUTHORIZED"), 
        "message" => Translator::translate("login.unauthorized") 
      );
    }

    return array(
      "code" => Configure::read("constant.SUCCESS"),
      "token" => $this->generateJWTToken($user)
    );
  }

  public function register(Register $request) {
    $user = $this->getUserByUsername($request->username);
    if (!$user) {
      try{
        $this->addUser($request);
        return array(
          "code" => Configure::read("constant.SUCCESS"),
          "message" => Translator::translate("register.success")
        );
      } catch(\PDOException $e) {
        return array(
          "code" => Configure::read("constant.ERR_INTERNAL"),
          "message" => $e->getMessage()
        );
      }
    }

    return array(
      "code" => Configure::read("constant.ERR_UNAUTHORIZED"),
      "message" => Translator::translate("register.error_user_exist")
    );
  }

  public function reset($email) {

  }

  public function getTokenInformation($token) {
    try{
      return JWT::decode($token, Configure::read("app.token.key"), array("HS256"));
    } catch (\Exception $e) {
      return Translator::translate("error_message." . StringHelper::toSnakeCase($e->getMessage()));
    }
  }

  public function generateJWTToken(User $user) {
    unset($user->password);
    unset($user->username);
    unset($user->email);
    $payload = array(
      "iss" => $_SERVER["SERVER_NAME"],
      "exp" => time() + Configure::read("app.token.expired"),
      "data" => $user
    );

    return JWT::encode($payload, Configure::read('app.token.key'));
  }

  public function isVerifiedPassword(User $user, $password) {
    return md5($password) === $user->password;
  }
  public function getUserByUsername($username) {
    return ((new Users()))->getUserByUsername($username);
  }

  public function setUser($user) {
    $this->user = $user;
  }

  public function getUser() {
    return $this->user;
  }

  private function addLoginAttempt($username) {
    $attempt = $this->getLoginAttempt();
    $countAttempt = empty($attempt) ? 0 : (int)$attempt;
    $countAttempt++;
    $this->cache->set($this->cacheKey, $countAttempt, self::LOGIN_ATEMPT_INTERVAL); 
  }

  private function getLoginAttempt() {
    return $this->cache->get($this->cacheKey);
  }

  private function setLoginAttemptCacheKey($username) {
    $this->cacheKey = str_replace("{username}", $username, self::LOGIN_ATEMPT_KEY);
  }

  private function generatePassword($limit) {
    return substr(base_convert(sha1(uniqid(mt_rand())), 16,36), 0, $limit);
  }

  private function addUser(Register $registerUser) {
    $user = new User();
    $user->username = $registerUser->username;
    $user->firstName = $registerUser->firstName;
    $user->lastName = $registerUser->lastName;
    $user->email = $registerUser->email;
    $user->password = \md5($registerUser->password);
    $user->userGroup->id = $registerUser->userGroupId;

    return (new Users())->addUser($user);
  }
}