<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{

    use HasFactory;
    protected $fillable = [
        'enrollment_id',
        'certificate_number',
        'certificate_url',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    /**
     * Boot the model and generate certificate number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($certificate) {
            if (empty($certificate->certificate_number)) {
                $certificate->certificate_number = static::generateCertificateNumber();
            }
        });
    }

    /**
     * Generate unique certificate number
     * Format: CERT-SA-YEAR-08-XXXX
     */
    public static function generateCertificateNumber()
    {
        $year = date('Y');
        $code = '08'; // Course category code

        // Get latest certificate number for this year
        $latestCertificate = static::whereYear('issued_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($latestCertificate && preg_match('/CERT-SA-\d{4}-\d{2}-(\d{4})/', $latestCertificate->certificate_number, $matches)) {
            $sequence = intval($matches[1]) + 1;
        } else {
            $sequence = 1;
        }

        return sprintf('CERT-SA-%s-%s-%04d', $year, $code, $sequence);
    }
}
