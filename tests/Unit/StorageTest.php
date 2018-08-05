<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Storage;

class StorageTest extends TestCase
{
    protected $testPair;

    public function setUp()
    {
      parent::setUp();
      $this->testPair = factory(Storage::class)->make();
    }

    /**
     * A test where new key-value pair is set to the storage model
     *
     * @return void
     */
    public function testSetNewPair()
    {
      // 1.
      $countBefore = Storage::count();

      // 2.
      $setResult = Storage::setValue($this->testPair->key, $this->testPair->user_id, $this->testPair->value);

      // 3.
      $expectedPair = Storage::getValue($this->testPair->key, $this->testPair->user_id);
      $this->assertEquals($this->testPair->value, $expectedPair->value);

      $countAfter = Storage::count();
      $this->assertEquals($countAfter, $countBefore+1);
    }

    public function testSetPairWithTheSameKey()
    {
      $otherValue = factory(Storage::class)->make()->value;

      Storage::setValue($this->testPair->key, $this->testPair->user_id, $this->testPair->value);

      $countBefore = Storage::count();

      Storage::setValue($this->testPair->key, $this->testPair->user_id, $otherValue);

      $countAfter = Storage::count();

      $expectedPair = Storage::getValue($this->testPair->key, $this->testPair->user_id);

      $this->assertEquals($otherValue, $expectedPair->value);
      $this->assertEquals($countAfter, $countBefore);
    }

    public function testGetNonexistingKey()
    {
      $expectedPair = Storage::getValue($this->testPair->key, $this->testPair->user_id);
      $this->assertNull($expectedPair);
    }
}
