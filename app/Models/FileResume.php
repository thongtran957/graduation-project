<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileResume extends Model
{
    public $table = "files";
    public $primaryKey = "id";
    public $fillable = [
        'file_name',
        'annotate',
        'train',
        'file_train',
        'created_at',
        'updated_at'
    ];
}
