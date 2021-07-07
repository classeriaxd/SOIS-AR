<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use \App\Models\User;

class LoginTest extends TestCase
{
    /**
     * Unit Test for Login Module
    */ 
    use RefreshDatabase;

    public function test_user_logs_in_with_correct_credentials()
    {
        // TC-LOGIN-1
        // Test Data 
        $email = 'test@email.com';
        $password = 'test@email.com';

        // Make User
        $user = User::factory()->create(['email' => $email, 'password' => Hash::make($password)]);

        // Login 
        $this->call('POST', '/login',[
            '_token' => csrf_token(),
            'email' => $email,
            'password' => $password,]);

        // Get Response 
        $response = $this->actingAs($user)->get('/home');
        $response->assertOk();
    }
    public function test_user_logs_in_with_incorrect_password()
    {
        // TC-LOGIN-2
        // Test Data 
        $email = 'test@email.com';
        $password = 'test@email.com';
        $wrong_password = 'wrong_password';

        // Make User
        $user = User::factory()->create(['email' => $email, 'password' => Hash::make($password)]);

        // Login
        $response = $this->call('POST', '/login',[
            '_token' => csrf_token(),
            'email' => $email,
            'password' => $wrong_password,]);

        // Get Response
        $response->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.'
        ]);
    }
    public function test_user_logs_in_with_incorrect_credentials()
    {
        // TC-LOGIN-3
        // Test Data 
        $email = 'test@email.com';
        $password = 'test@email.com';
        $invalid_email = 'invalid_email@email.com';
        $wrong_password = 'wrong_password';

        // Make User
        $user = User::factory()->create(['email' => $email, 'password' => Hash::make($password)]);

        // Login
        $response = $this->call('POST', '/login',[
            '_token' => csrf_token(),
            'email' => $invalid_email,
            'password' => $wrong_password,]);

        // Get Response
        $response->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.'
        ]);
    }
    public function test_user_logs_in_with_no_credentials()
    {
        // TC-LOGIN-4
        // Test Data 
        $email = '';
        $password = '';

        // Login
        $response = $this->call('POST', '/login',[
            '_token' => csrf_token(),
            'email' => $email,
            'password' => $password,]);

        // Get Response
        $response->assertSessionHasErrors([
           'email' => 'The email field is required.',
           'password' => 'The password field is required.'
        ]);
    }

}
