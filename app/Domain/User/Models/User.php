<?php

namespace App\Domain\User\Models;

use Database\Factories\Domain\User\Models\UserFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Lang;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $document
 * @property string $birth_date
 * @property string $phone_number
 * @property string $zip_code
 * @property string $uf
 * @property string $city
 * @property string $neighborhood
 * @property string $address
 * @property boolean $status
 *
 * @method Builder filterInactive()
 * @method UserFactory factory()
 */
class User extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'document',
        'birth_date',
        'phone_number',
        'zip_code',
        'uf',
        'city',
        'neighborhood',
        'address',
        'status',
    ];

    public function getStatusAttribute(): bool
    {
        return filter_var($this->attributes['status'], FILTER_VALIDATE_BOOL);
    }

    public function getUfAttribute(): string
    {
        return strtoupper($this->attributes['uf']);
    }

    public function getTextualStatusAttribute(): string
    {
        return Lang::choice("user.values.status", $this->attributes['status']);
    }
}
