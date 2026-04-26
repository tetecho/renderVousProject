<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    /** @use HasFactory<\Database\Factories\RendezVousFactory> */
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'service_id',
        'date_heure',
        'statut',
    ];

    protected $casts = [
        'date_heure' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function medecin()
    {
        return $this->belongsTo(User::class, 'medecin_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
