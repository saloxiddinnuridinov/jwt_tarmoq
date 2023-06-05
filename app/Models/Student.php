<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * @OA\Schema(
 *  schema="Student",
 *  title="Student",
 *  required={"name", "surname", "email", "status", "is_blocked", "password", "balance", },
 *   @OA\Property(property="name_uz",type="string",@OA\Schema(example="Tana")),
 *   @OA\Property(property="name_ru",type="string",@OA\Schema(example="body")),
 *   @OA\Property(property="image",type="string",@OA\Schema(format="binary",example="image.url")),
 *   @OA\Property(property="parent_id",type="integer",@OA\Schema(example="1")),
 *   @OA\Property(property="created_at",type="date"),
 *   @OA\Property(property="updated_at",type="date"),
 * )
 */
class Student extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $fillable =['name','surname','email', 'status', 'block_reason', 'is_blocked', 'password', 'balance','birthday'];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
