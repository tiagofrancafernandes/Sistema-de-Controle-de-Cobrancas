<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ProposalStaus;
use App\Enums\BladeViewType;

class Proposal extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'status',
        'expires_in',
        'template_view',
        'template_view_plain',
        'template_view_type',
        'final_text',
        'final_rendered_at',
        'content_data',
        'customer_uuid',
        'amount',
        'accept_date',
        'accept_password',
    ];

    protected $hidden = [
        'accept_password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'template_view' => 'string',
            'template_view_plain' => 'string',
            'template_view_type' => BladeViewType::class,
            'final_text' => 'string',
            'final_rendered_at' => 'timestamp',
            'status' => ProposalStaus::class,
            'expires_in' => 'timestamp',
            'content_data' => AsCollection::class,
            'amount' => 'double',
            'accept_date' => 'timestamp',
            'accept_password' => 'hashed',
        ];
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array
     */
    public function uniqueIds(): array
    {
        return [
            'uuid',
        ];
    }
}
