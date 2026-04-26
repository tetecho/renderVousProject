<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function rendezVousAsPatient()
    {
        return $this->hasMany(RendezVous::class, 'patient_id');
    }

    public function rendezVousAsMedecin()
    {
        return $this->hasMany(RendezVous::class, 'medecin_id');
    }


    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    public function isMedecin(): bool
    {
        return $this->role === 'medecin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}