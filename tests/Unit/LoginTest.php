<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Support\Facades\Hash;
use \App\Models\User;

class LoginTest extends TestCase
{
    /**
     * Unit Test for Login Module
     */
    use RefreshDatabase;

    public function test_user_logs_in_with_correct_credentials()
    {
        // TEST: User logs-in with correct credentials 
        // Test Data 
        $email = 'test@email.com';
        $password = 'test@email.com';

        // Make User
        $user = User::factory()->create(['email' => $email, 'password' => Hash::make($password)]);

        // Login 
        $response = $this->call('POST', '/login',[
            '_token' => csrf_token(),
            'email' => $email,
            'password' => $password,]);

        // Get Response 
        $response2 = $this->actingAs($user)->get('/home');
        $response2->assertOk();
    }

    public function test_user_logs_in_with_incorrect_password()
    {
        // TEST: User logs-in with incorrect password
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
        // TEST: User logs-in with incorrect credentials
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
        // TEST: User logs-in with no credentials
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
