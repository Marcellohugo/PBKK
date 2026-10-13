<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'deskripsi', 'tema_agent', 'pertanyaan_riset', 'mode_riset', 'jumlah_artikel', 'jumlah_pdf'];

    protected function casts(): array
    {
        return ['api_key_secure' => 'encrypted', 'jumlah_artikel' => 'integer', 'jumlah_pdf' => 'integer'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
