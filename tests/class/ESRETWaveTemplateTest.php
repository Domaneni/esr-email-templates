<?php

class ESRETWaveTemplateTest extends WP_UnitTestCase {

    public function __construct() {
        parent::__construct();
    }


    public function setUp(): void {
        parent::setUp();
    }

    public function test_get_currency() {
        $this->assertEquals('USD', ESR()->currency->esr_get_currency());

    }

}
