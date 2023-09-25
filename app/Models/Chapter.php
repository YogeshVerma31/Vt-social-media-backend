<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['status'];


    public static function getChapterBySubject($id)
    {

        $data =  Chapter::Join('sub_categories', 'chapters.subcategory', '=', 'sub_categories.id')
            ->select('chapters.*', 'sub_categories.subcategory_name')
            ->where('sub_categories.id', '=', $id)
            ->get();
        return $data;
    }

    public static function index()
    {
        $data =  Chapter::Join('sub_categories', 'chapters.subcategory', '=', 'sub_categories.id')
            ->select('chapters.*', 'sub_categories.subcategory_name')
            ->get();
        return $data;
    }
}
