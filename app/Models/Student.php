<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Stancl\Tenancy\Database\Concerns\TenantConnection;
use App\Enums\EntityDocumentType;

class Student extends Model
{
    use HasFactory;
    use BelongsToTenant;
    use TenantConnection;

    protected $fillable = [
        'name',
        'email',
        'document1_value',
        'document1_type',
        'document2_value',
        'document2_type',
        'phone1',
        'phone2',
    ];

    protected $casts = [
        'document1_type' => EntityDocumentType::class,
        'document2_type' => EntityDocumentType::class,
    ];
}
