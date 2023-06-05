<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="Tarmoq Xavfsizligi",
 *    version="1.0.0",
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     name="Token based Based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="api",
 * ),
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     name="Token based Based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="student",
 * ),
 *
 * @OA\Tag(
 * name = "Auth",
 * description = "Authdan o'tish",
 * ),
 *
 * @OA\Tag(
 * name = "Category",
 * description = "Category CRUD",
 * ),
 *
 * @OA\Tag(
 * name = "User",
 * description = "User CRUD",
 * ),
 *
 * @OA\Tag(
 * name = "Student",
 * description = "Student CRUD",
 * ),
 *
 *
 * @OA\Tag(
 * name = "Lessons",
 * description = "Lesson CRUD",
 * ),
 *
 * @OA\Tag(
 * name = "Terms",
 * description = "Term CRUD",
 * ),
 *
 * @OA\Tag(
 * name = "--Student-------------------------Student-------------------------------Student--------------------Student--",
 * description = "",
 * ),
 * @OA\Tag(
 * name = "Auth Student",
 * description = "Studentlar uchun Authdan o'tish",
 * ),
 * @OA\Tag(
 * name = "Terms Student",
 * description = "Studentlar uchun Termlarni olish",
 * ),
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}


// Install JWT
// Publish JWT Config
// Generate JWT Secret
// Configure Auth configuration
// Implement JWTSubject interface in User model
// Create API route
// Create AuthController with login, register, refresh, logout and profile method
// Create Todo Model with migration and resource TodoController
// Migrate database
// Modify UserFactory
// Create and modify TodoFactory
// Use of a Psy Shell Laravel Tinker
// Create some dummy users and Todo data
// Use a RESTful API client Postman
// Test User login, register, refresh, logout and user profile
// Test Todo view, create, modify and delete
