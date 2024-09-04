<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $last_name
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
        'last_name',
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

    protected $appends = [
        'full_name'
    ];

    public function getStatusAttribute(): bool
    {
        return filter_var($this->attributes['status'], FILTER_VALIDATE_BOOL);
    }

    public function getFullNameAttribute(): string
    {
        return $this->attributes['name'] . ' ' . $this->attributes['last_name'];
    }
}
