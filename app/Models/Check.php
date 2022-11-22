<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Check extends Model
{
    use HasFactory;

    protected $fillable = [
        'check',
    ];

    public function user()
    {
    return $this->balongsTo(User::class);
    }


    public function thread()
    {
        return $this->hasOne(Thread::class);
    }

    public function check_url()
    {
        return Storage::url($this->image_path);
    }
}
