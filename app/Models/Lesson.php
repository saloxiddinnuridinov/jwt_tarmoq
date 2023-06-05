<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *  schema="Lesson",
 *  title="Lesson",
 *  required={"title_uz", "title_ru", "category_id"},
 *   @OA\Property(property="title_uz",type="string"),
 *   @OA\Property(property="title_ru",type="string"),
 *   @OA\Property(property="category_id",type="integer"),
 *   @OA\Property(property="created_at",type="date"),
 *   @OA\Property(property="updated_at",type="date"),
 * )
 */
class Lesson extends Model
{
    use HasFactory;

    protected $fillable =['title_uz', 'title_ru', 'title_en', 'category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
