<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class JobTest extends TestCase
{
    protected function authenticate()
    {
        $user = User::where('email', 'hazem@eden.com')->first();
        if (!auth()->attempt(['email'=>$user->email, 'password'=>'123456'])) {
            return response(['message' => 'Login credentials are invaild']);
        }
        return auth()->user()->createToken('regular')->accessToken;
    }

    protected function authenticateManager()
    {
        $user = User::where('email', 'manager@eden.com')->first();
        if (!auth()->attempt(['email'=>$user->email, 'password'=>'123456'])) {
            return response(['message' => 'Login credentials are invaild']);
        }
        return auth()->user()->createToken('manager')->accessToken;
    }

    public function test_get_jobs()
    {
        $token = $this->authenticateManager();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','/api/v1/manager/jobs');

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);
        $response->assertStatus(200);
    }


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_job()
    {
        $token = $this->authenticate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST','/api/v1/regular/jobs',[
            "title" => "test 2",
            "description" => "h0000000ello world"
        ]);

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);
        $response->assertStatus(201);
    }

    public function test_update_job()
    {
        $token = $this->authenticate();

        $job = Job::where('id', Auth::id())->first();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT',"/api/v1/regular/jobs/{$job->id}",[
            "title" => "test 2",
            "description" => "h0000000ello world"
        ]);

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);
        $response->assertStatus(202);
    }
}
