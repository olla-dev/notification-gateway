<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use Illuminate\Support\Facades\Storage;
use Artisan;
use Illuminate\Support\Facades\DB;

class NotificationControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        touch('./tests.sqlite');

        parent::setUp();

        Artisan::call('migrate');
        $this->seed();
        
        Artisan::call('apikey:generate test');
    }


    public function tearDown() : void
    {
        unlink('./tests.sqlite');
    }

    /** 
    public function should_fail_when_no_api_key()
    {
        $response = $this->post('api/notify', [
            'aaaa' => 'aaa'
        ]);

        $response->assertStatus(401);
    }*/



    /** @test */
    public function should_succeed_when_api_key_provided()
    {
        $this->withoutExceptionHandling();

        $apiKey = DB::select('select key from api_keys where active = ? LIMIT 1', [1]);

        print json_decode($apiKey[0])->key;

        $response = $this->get('api/ping', [], ['X-Authorization', json_decode($apiKey[0])->key]);

        $response->assertSeeText('Notification API is live.');
    }
}



