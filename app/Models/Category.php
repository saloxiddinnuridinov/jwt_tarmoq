<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *  schema="Category",
 *  title="Category",
 *  required={"name_uz", "name_ru", "image", "parent_id"},
 *   @OA\Property(property="name_uz",type="string",@OA\Schema(example="Tana")),
 *   @OA\Property(property="name_ru",type="string",@OA\Schema(example="body")),
 *   @OA\Property(property="image",type="string",@OA\Schema(format="binary",example="image.url")),
 *   @OA\Property(property="parent_id",type="integer",@OA\Schema(example="1")),
 *   @OA\Property(property="created_at",type="date"),
 *   @OA\Property(property="updated_at",type="date"),
 * )
 */
class Category extends Model
{
    use HasFactory;
    protected $fillable =['name_uz','name_ru','image','parent_id'];

}
