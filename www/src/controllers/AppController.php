<?php
namespace Dharmatin\Simk\Controller;

use Dharmatin\Simk\Core\Controller;
use Dharmatin\Simk\Library\Translator;

class AppController extends Controller {
  protected $translator;

  public function __construct() {
    parent::__construct();
    $this->translator = new Translator();
  }
}