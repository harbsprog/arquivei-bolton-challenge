<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tymon\JWTAuth\Http\Middleware\Authenticate;

class NfeTest extends TestCase
{
    use WithFaker, DatabaseMigrations, RefreshDatabase;

    private $authUser;
    private $authToken;
    private $route = [
        'nfe_success' => '',
        'nfe_error' => '',
        'auth' => ''
    ];


    private $access_key_success = '35171154759614000180550000000516221712058461';
    private $access_key_delete = '35170591390526000180550010002510171243966493';
    private $access_key_error = '134784';

    public function setUp(): void
    {

        parent::setUp();

        $this->route['nfe_success'] = "api/nfe/{$this->access_key_success}";
        $this->route['nfe_error'] = "api/nfe/{$this->access_key_error}";
        $this->route['nfe_delete'] = "api/nfe/{$this->access_key_delete}";
        $this->route['auth'] = "api/auth/login";
    }

    /**
     * Test find Nfe by acess_key.
     *
     * @return void
     */
    public function testFindByAccessKey()
    {

        //Disabling Auth
        $this->withoutMiddleware(Authenticate::class);

        //Test Success
        $responseSuccess = $this->get($this->route['nfe_success']);
        $responseSuccess->assertSuccessful();

        //Test Error
        $responseError = $this->get($this->route['nfe_error']);
        $responseError->assertSuccessful()
            ->assertJson([
                'message' => 'Nfe not found, we will capture, try again in a few moments if exists.'
            ]);
    }

    /**
     * Test Too Many Requests Arquivei Sandbox.
     *
     * @return void
     */
    public function testTooManyRequests()
    {

        //Disabling Auth
        $this->withoutMiddleware(Authenticate::class);

        for ($i = 0; $i <= 100; $i++) {

            $response = $this->get($this->route['nfe_success']);

            if ($i < 100) {

                //Test Success
                $response->assertSuccessful();
            } else {

                //Test Error
                $response->assertStatus(429);
            }
        }
    }

    /**
     * Test user unauthenticated.
     *
     * @return void
     */
    public function testUnauthenticated()
    {

        //Test Success
        $responseSuccess = $this->get($this->route['nfe_success']);
        $responseSuccess->assertStatus(401);
    }
}
