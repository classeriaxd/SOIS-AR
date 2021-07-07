<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Carbon\Carbon;

use \App\Models\User;
use \App\Models\Event;

class EventReportTest extends TestCase
{
    /**
     * Unit Test for Event Reports Module
     */

    use RefreshDatabase;
/*
    public function test_creates_an_event_with_all_mandatory_fields_filled_out()
    {
        // TC-CREATE-AR-1
        // Test User
        $user = User::factory()->create();
        // Test Data
        $test_data = [
            '_token' => csrf_token(),
            'title' => 'Sample Event',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'objective' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'date' => '2021-01-01',
            'start_time' => '08:00',
            'end_time' => '15:00',
            'venue' => 'Sample Venue',
            'activity_type' => 'Sample Activity Type',
            'beneficiaries' => 'Sample Beneficiaries',
            'sponsors' => 'Sample Sponsors',
            'budget' => '1000',];
        // Create Event Report
        $this->actingAs($user)->call('POST', '/e', $test_data);
        // Get Event Report URL slug
        $test_data_slug = Str::replace(' ', '-', $test_data['title']).'-'.Carbon::createFromFormat('Y-m-d', $test_data['date'])->format('Y');
        
        // Get Response
        $response = $this->actingAs($user)->call('GET', '/e/'.$test_data_slug);
        $response->assertOk();
    }
    public function test_creates_an_event_without_filling_any_fields()
    {
        // TC-CREATE-AR-2
        // Test User
        $user = User::factory()->create();
        // Test Data
        $test_data = ['_token' => csrf_token(),];
        // Create Event Report
        $response = $this->actingAs($user)->call('POST', '/e', $test_data);
        // Get Response
        $response->assertSessionHasErrors([
           'title' => 'The title field is required.',
           'description' => 'The description field is required.',
           'date' => 'The date field is required.',
           'venue' => 'The venue field is required.',
           'activity_type' => 'The activity type field is required.',
           'beneficiaries' => 'The beneficiaries field is required.',
           'sponsors' => 'The sponsors field is required.',
        ]);
    }
    public function test_creates_an_event_with_special_characters_in_fields()
    {
        // TC-CREATE-AR-3
        // Test User
        $user = User::factory()->create();
        // Test Data
        $test_data = [
            '_token' => csrf_token(),
            'title' => 'AaBbCcDdEe 12354/--+-',
            'description' => 'Lorem ipsum AaBbCcDdEe 12354/--+-',
            'objective' => 'Lorem ipsum AaBbCcDdEe 12354/--+-',
            'date' => '2021-01-01',
            'start_time' => '08:00',
            'end_time' => '15:00',
            'venue' => 'Sample Venue',
            'activity_type' => 'AaBbCcDdEe 12354/--+-',
            'beneficiaries' => 'AaBbCcDdEe 12354/--+-',
            'sponsors' => 'AaBbCcDdEe 12354/--+-',
            'budget' => '1000',];
        // Create Event Report
        $response = $this->actingAs($user)->call('POST', '/e', $test_data);
        // Get Response
        $response->assertSessionHasErrors([
           'title' => 'The title format is invalid.',
        ]);
    }
    public function test_creates_an_event_with_multiple_beneficiaries_and_sponsors()
    {
        // TC-CREATE-AR-4
        // Test User
        $user = User::factory()->create();
        // Test Data
        $test_data = [
            '_token' => csrf_token(),
            'title' => 'Sample Event',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'objective' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'date' => '2021-01-01',
            'start_time' => '08:00',
            'end_time' => '15:00',
            'venue' => 'Sample Venue',
            'activity_type' => 'Sample Activity Type',
            'beneficiaries' => 'Sample Beneficiaries1, Sample Beneficiaries2',
            'sponsors' => 'Sample Sponsors1, Sample Sponsors2',
            'budget' => '1000',];
        // Create Event Report
        $this->actingAs($user)->call('POST', '/e', $test_data);
        // Get Event Report URL slug
        $test_data_slug = Str::replace(' ', '-', $test_data['title']).'-'.Carbon::createFromFormat('Y-m-d', $test_data['date'])->format('Y');
        
        // Get Response
        $response = $this->actingAs($user)->call('GET', '/e/'.$test_data_slug);
        $response->assertOk();
    }
    public function test_creates_an_event_with_invalid_date_using_0000_00_00()
    {
        // TC-CREATE-AR-5
        // Test User
        $user = User::factory()->create();
        // Test Data
        $test_data = [
            '_token' => csrf_token(),
            'title' => 'Sample Event',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'objective' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'date' => '0000-00-00',
            'start_time' => '00:00',
            'end_time' => '00:00',
            'venue' => 'Sample Venue',
            'activity_type' => 'Sample Activity Type',
            'beneficiaries' => 'Sample Beneficiaries',
            'sponsors' => 'Sample Sponsors',
            'budget' => '1000',];
        // Create Event Report
        $response = $this->actingAs($user)->call('POST', '/e', $test_data);
        // Get Response
        $response->assertSessionHasErrors([
           'date' => 'The date is not a valid date.',
           'end_time' => 'The end time must be a date after start time.',
        ]);
    }
    public function test_creates_an_event_with_invalid_date_and_time_using_characters()
    {
        // TC-CREATE-AR-6
        // Test User
        $user = User::factory()->create();
        // Test Data
        $test_data = [
            '_token' => csrf_token(),
            'title' => 'Sample Event',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'objective' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'date' => 'A@b#-AA-&&',
            'start_time' => 'AA:&&',
            'end_time' => 'AA:&&',
            'venue' => 'Sample Venue',
            'activity_type' => 'Sample Activity Type',
            'beneficiaries' => 'Sample Beneficiaries',
            'sponsors' => 'Sample Sponsors',
            'budget' => '1000',];
        // Create Event Report
        $response = $this->actingAs($user)->call('POST', '/e', $test_data);
        // Get Response
        $response->assertSessionHasErrors([
           'date' => 'The date is not a valid date.',
           'start_time' => 'The start time does not match the format H:i.',
           'end_time' => 'The end time does not match the format H:i.',
           'end_time' => 'The end time must be a date after start time.',
        ]);
    }
    public function test_creates_an_event_with_invalid_date_and_time_using_values_out_of_range()
    {
        // TC-CREATE-AR-7
        // Test User
        $user = User::factory()->create();
        // Test Data
        $test_data = [
            '_token' => csrf_token(),
            'title' => 'Sample Event',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'objective' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'date' => '999999-13-32',
            'start_time' => '25:60',
            'end_time' => '25:61',
            'venue' => 'Sample Venue',
            'activity_type' => 'Sample Activity Type',
            'beneficiaries' => 'Sample Beneficiaries',
            'sponsors' => 'Sample Sponsors',
            'budget' => '1000',];
        // Create Event Report
        $response = $this->actingAs($user)->call('POST', '/e', $test_data);
        // Get Response
        $response->assertSessionHasErrors([
           'date' => 'The date is not a valid date.',
           'start_time' => 'The start time does not match the format H:i.',
           'end_time' => 'The end time does not match the format H:i.',
        ]);
    }
    public function test_creates_an_event_with_a_past_date()
    {
        // TC-CREATE-AR-9
        // Test User
        $user = User::factory()->create();
        // Test Data
        $test_data = [
            '_token' => csrf_token(),
            'title' => 'Sample Event',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'objective' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'date' => '2000-01-11',
            'start_time' => '08:00',
            'end_time' => '15:00',
            'venue' => 'Sample Venue',
            'activity_type' => 'Sample Activity Type',
            'beneficiaries' => 'Sample Beneficiaries',
            'sponsors' => 'Sample Sponsors',
            'budget' => '1000',];
        // Create Event Report
        $this->actingAs($user)->call('POST', '/e', $test_data);
        // Get Event Report URL slug
        $test_data_slug = Str::replace(' ', '-', $test_data['title']).'-'.Carbon::createFromFormat('Y-m-d', $test_data['date'])->format('Y');
        
        // Get Response
        $response = $this->actingAs($user)->call('GET', '/e/'.$test_data_slug);
        $response->assertOk();
    }
    public function test_creates_an_event_with_an_invalid_budget()
    {
        // TC-CREATE-AR-14
        // Test User
        $user = User::factory()->create();
        // Test Data
        $test_data = [
            '_token' => csrf_token(),
            'title' => 'Sample Event',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'objective' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'date' => '2021-01-01',
            'start_time' => '08:00',
            'end_time' => '15:00',
            'venue' => 'Sample Venue',
            'activity_type' => 'Sample Activity Type',
            'beneficiaries' => 'Sample Beneficiaries',
            'sponsors' => 'Sample Sponsors',
            'budget' => 'AaBbCcDdEe/--+-@$%',];
        // Create Event Report
        $response = $this->actingAs($user)->call('POST', '/e', $test_data);

        // Get Response
        $response->assertSessionHasErrors([
           'budget' => 'The budget must be a number.',
        ]);
    }*/
    public function test_creates_an_event_with_some_mandatory_fields_not_filled_out()
    {
        // TC-CREATE-AR-15
        // Test User
        $user = User::factory()->create();
        // Test Data
        $test_data = [
            '_token' => csrf_token(),
            'title' => '',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'objective' => '',
            'date' => '2021-01-01',
            'start_time' => '08:00',
            'end_time' => '15:00',
            'venue' => 'Sample Venue',
            'activity_type' => 'Sample Activity Type',
            'beneficiaries' => 'Sample Beneficiaries',
            'sponsors' => 'Sample Sponsors',
            'budget' => '1000',];
        // Create Event Report
        $response = $this->actingAs($user)->call('POST', '/e', $test_data);
        // Get Response
        $response->assertSessionHasErrors([
           'title' => 'The title field is required.',
           'objective' => 'The objective field is required.',
        ]);
    }
}
