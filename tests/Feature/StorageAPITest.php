<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Storage;
use App\ApiKey;

class StorageAPITest extends TestCase
{
    public function setUp()
    {
      parent::setUp();
      $this->testApiKey = factory(ApiKey::class)->create();

      $this->testPair = factory(Storage::class)->make();
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSuccessfullySetPair()
    {
      $res = $this->json('POST', '/api/v1/storage',
        [
          'key' => $this->testPair->key,
          'value' => $this->testPair->value,
          'apiKey' => $this->testApiKey->key
        ]);
      $res->assertStatus(200);
      $res->assertJsonFragment([$this->testPair->key => $this->testPair->value]);
    }

    public function testSuccessfullyGetPair()
    {
      $this->json('POST', '/api/v1/storage',
        [
          'key' => $this->testPair->key,
          'value' => $this->testPair->value,
          'apiKey' => $this->testApiKey->key
        ]);

      $res = $this->json('GET', '/api/v1/storage',
        [
          'key' => $this->testPair->key,
          'apiKey' => $this->testApiKey->key
        ]);

      $res->assertStatus(200);
      $res->assertJsonFragment([$this->testPair->key => $this->testPair->value]);
    }

    public function testAccessDeniedGetRequest()
    {
      $res = $this->json('GET', '/api/v1/storage',
        [
          'key' => $this->testPair->key,
          'value' => $this->testPair->value
        ]);

      $res->assertStatus(401);
    }

    public function testGetKeyNotFound()
    {
      $testKey = factory(Storage::class)->make()->key;
      $res = $this->json('GET', '/api/v1/storage',
        [
          'key' => $testKey,
          'apiKey' => $this->testApiKey->key
        ]);

      $res->assertStatus(404);
    }
}
