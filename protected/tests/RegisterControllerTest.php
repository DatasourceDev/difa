<?php

class RegisterControllerTest extends CTestCase {

    public function setUp() {
        $this->api = new RegisterController();
    }

    public function tearDown() {
        unset($this->api);
    }

}
