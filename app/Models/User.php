<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'reg_no',
        'class_room',
        'score',
        'completed_lessons',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'score' => 'integer',
        'completed_lessons' => 'array',
    ];

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function getRoleBadgeAttribute(): string
    {
        return $this->isGuru() ? 'Guru Jepang' : 'Siswa';
    }

    public function getRoleBadgeClassAttribute(): string
    {
        return $this->isGuru() ? 'badge-guru' : 'badge-siswa';
    }

    public function assessments()
    {
        return $this->hasMany(StudentAssessment::class, 'user_id')->orderBy('created_at', 'desc');
    }

    public function getAverageAssessmentScoreAttribute(): ?int
    {
        StudentAssessment::ensureTableExists();
        $avg = $this->assessments()->avg('score');
        return $avg !== null ? (int) round($avg) : null;
    }

    /**
     * Memastikan kolom reg_no dan class_room tersedia di tabel users
     */
    public static function ensureSchemaReady(): void
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
                \Illuminate\Support\Facades\Schema::table('users', function (\Illuminate\Database\Schema\Blueprint $table) {
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'reg_no')) {
                        $table->string('reg_no')->nullable();
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'class_room')) {
                        $table->string('class_room')->nullable();
                    }
                });
            }
        } catch (\Throwable $e) {
            // Fail-safe jika schema sudah siap
        }
    }
}
