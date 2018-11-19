<?php

namespace Dharmatin\Simk\Library;

use Dharmatin\Simk\Core\Configure;

class Memcached {
  private $cache;
  public function __construct(){
    $config = new Connection\Configuration;
    $config->port = Configure::read("memcached.port");
    $config->host = Configure::read("memcached.host");
    $this->cache = (new Connection\Memcached($config))->getConnection();
  }

  public function set($key, $data, $expire = 0) {
    $expiredTime = empty($expire) ? Configure::read("memcached.expired") : $expire;
    $this->cache->set($key, $data, $expiredTime);
  }

  public function get($key) {
    return $this->cache->get($key);
  }
}