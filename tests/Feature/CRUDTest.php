<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;
use phpDocumentor\Reflection\Types\Null_;

class CRUDTest extends TestCase
{
    public $testId;
    public const TEST_NAME = "TestName";
    public const TEST_COURSE = "Engineer";
    public const ENTRY_POINT_URL = "/api/students";


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_path()
    {
        //apiのパスをチェック
        $base_url = '/api/students';
        $response = $this->get($base_url);
        $response->assertStatus(200);
    }

    public function test_create()
    {
        //テストデータをPOST送信でCREATE
        $response = $this->post(self::ENTRY_POINT_URL, [
            'name' => self::TEST_NAME,
            'course' => self::TEST_COURSE
        ]);

        //testIdにレスポンスで帰ってきたIDをセット
        $this->testId = $response->getdata()->id;

        //  responseに入っているメッセージとIDが正しいかどうか検証
        $response->assertJson(fn (AssertableJson $json) =>
        $json->where('message', 'student record created')
            ->where('id', $this->testId));

        //帰ってくる通信が201か調べる。（200ではない）
        $response->assertStatus(201);
    }

    public function test_read()
    {
        //読み込んできたデータが正しい構造かどうか調べる
        $response = $this->get(self::ENTRY_POINT_URL);
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->whereAllType(['0.id' => 'integer', '0.name' => 'string'])
        );
    }

    public function test_update()
    {

        $response = $this->post(self::ENTRY_POINT_URL, [
            'name' => self::TEST_NAME,
            'course' => self::TEST_COURSE
        ]);

        //testIdにレスポンスで帰ってきたIDをセット
        $this->testId = $response->getdata()->id;
        //実際はたぶんtestIdの行にまったく別なものを入れるコードが先に来る
        // global $testId;
        //putでTEST用のデータにアップデート
        $response = $this->put(self::ENTRY_POINT_URL . "/" . $this->testId, [
            "name" => self::TEST_NAME,
            "course" => self::TEST_COURSE
        ]);

        
        //正しいメッセージが帰ってくるかどうか
        $response->assertJson(fn (AssertableJson $json) =>
        $json->where('message', 'records updated successfully'));
        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $response = $this->post(self::ENTRY_POINT_URL, [
            'name' => self::TEST_NAME,
            'course' => self::TEST_COURSE
        ]);

        $this->testId = $response->getdata()->id;


        $response = $this->delete(self::ENTRY_POINT_URL . "/" . "$this->testId");
        //delete後に202が帰ってきているか。
        $response->assertStatus(202);
        //deleteされたデータが残っていないか。
        $response = $this->get(self::ENTRY_POINT_URL . "/" . "$this->testId");
        $response->assertStatus(404);
    }
}
