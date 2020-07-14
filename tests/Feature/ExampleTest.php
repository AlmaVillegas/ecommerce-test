<?php
# tests/Feature/ExampleTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use app\User;
use app\Role;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    ///tes1
    public function testBasicTest()
    {
        $response = $this->get('/users/register');
        $response->assertSuccessful();
    }

    //test2
    public function testCreateUserEmail()
    {
        $data = [
            'name' => 'New User',
            'email'=> 'This is new user',
            'username' => 'This is new user',
            'password' => 'hola'];
        $user = factory(User::class)->create(); 
        $response = $this->actingAs($user,'api')->json('POST', '/api/users/register', $data);
        $response-> assertStatus(412);
        $response-> assertRegExp('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/','email');
        $response-> assertJson(['message'=> 'Incorrectly Formatted email!']);
        $response-> assertJson(['data'=> $data]);
    }
    //test3
    public function testCreateUserCharacter()
    {
        $data = [
            'name' => 'New User',
            'email'=> 'This is new user',
            'username' => 'This is new user',
            'password' => 'hola'
        ];
        $user = factory(User::class)->create(); 
        $response = $this->actingAs($user,'api')->json('POST', '/api/users/register', $data);
        $response-> assertStatus(412);
        $response-> assertRegExp('/[a-z{1}[A-Z]{1}[0-9]{1}]{8}/','password');
        $response-> assertJson(['message'=> 'Incorrectly Formatted password!']);
        $response-> assertJson(['data'=> $data]);
    }
    ///test4
    public function testCreateProductWithMiddleware()
    {
            $data = [
                'name' => 'New Product',
                'description'=> 'This is product',
                'price' => 20,
                'slug' => 'hola'
            ];
        $response = $this->json('POST', '/api/products',$data);
        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }
    //test5
    public function testCreateProduct()
    {
        $data = [
            'name' => 'New Product',
            'description'=> 'This is product',
            'price' => 20,
            'slug' => 'hola'];
        $user = factory(user::class)->create();
        $response = $this->actingAs($user,'api')->json('POST', '/api/products', $data);
        $response-> assertStatus(200);
        $response-> assertJson(['status'=> true]);
        $response-> assertJson(['message'=> 'product Created!']);
        $response-> assertJson(['data'=> $data]);
    }
    //test6
    public function testCreateProductPrice()
    {
        $data = [
            'name' => 'New Product',
            'description'=> 'This is product',
            'price' => '20',
            'slug' => 'hola'];
        $user = factory(user::class)->create();
        $response = $this->actingAs($user,'api')->json('POST', '/api/products', $data);
        $response-> assertStatus(412);
        $response-> assertJson(['status'=> true]);
        $response-> assertJson(['message'=> 'Incorrectly Formatted price, required number!']);
        $response-> assertJson(['data'=> $data]);
    }

}