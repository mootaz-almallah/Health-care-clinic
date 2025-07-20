<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;
    
    protected $fillable = ['symptom_key', 'display_name', 'description'];
    
    public $timestamps = false;
    protected $table = 'symptoms';
}