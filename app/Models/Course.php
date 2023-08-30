<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\File;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    public function getImageAttribute(string $value): string
    {
        if (str_contains($value, 'https')) {
            return $value;
        }

        return asset('storage/'.$value);
    }

    public function deleteLocalImage($image): void
    {
        $image = substr($image, 18);

        if (File::exists($image)) {
            File::delete($image);
        }
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
