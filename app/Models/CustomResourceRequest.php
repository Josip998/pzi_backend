<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomResourceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'email',
        // Add other fillable properties here
    ];

    // Add any relationships or other methods as needed
}
