<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\UserLocation;

class UserLocationTest extends TestCase
{

    public function test_can_save_location() {

        $data = [
            'user_id' =>   $this->faker->randomDigit,
            'latitude' =>  $this->faker->latitude,
            'longitude' => $this->faker->longitude
        ];

        $this->post(route('user_location.store'), $data)
            ->assertStatus(201);
    }


    public function test_can_show_post() {

        $userLocation = UserLocation::factory()->make();

        $this->get(route('user_location.show', $userLocation->user_id))
            ->assertStatus(200);
    }
}
