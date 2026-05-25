<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'filename',
        'original_name',
        'path',
        'mime_type',
        'size',
        'folder',
        'alt_text',
    ];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
        ];
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    public function getSizeFormattedAttribute(): string
    {
        $bytes = $this->size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        }
        return number_format($bytes / 1024, 1) . ' KB';
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function delete(): ?bool
    {
        Storage::disk('public')->delete($this->path);
        return parent::delete();
    }
}
