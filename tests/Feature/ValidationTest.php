<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    public const TEST_ID = "1";
    public const TEST_NAME = "TestName";
    public const TEST_COURSE = "Engineer";
    public const ENTRY_POINT_URL = "/api/students";
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_name_validation()
    {
        //name列に256文字を入れようとしたらはじかれるか検証
        $response = $this->post(self::ENTRY_POINT_URL,[
            'name' => sprintf("%'0256s", 0),
            'course' => self::TEST_COURSE
        ]);

        $response->assertStatus(500);
    }
}
