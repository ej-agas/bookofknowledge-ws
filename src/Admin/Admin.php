<?php


namespace BOK\Admin;

use Ramsey\Uuid\Uuid;
use BOK\Base\UserInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Admin extends Authenticatable implements UserInterface
{
    use SoftDeletes, SearchableTrait;

    public const RESOURCE_KEY = 'admins';

    public const INCLUDES = '';

    public const FILLABLES = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    protected $fillable = self::FILLABLES;

    protected $dates = [
        'deleted_at'
    ];

    public $incrementing = false;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            self::RESOURCE_KEY . '.first_name' => 10,
            self::RESOURCE_KEY . '.last_name' => 10,
            self::RESOURCE_KEY . '.middle_name' => 5,
            self::RESOURCE_KEY . '.email' => 5
        ]
    ];

    public static function boot(): void
    {
        parent::boot();

        self::creating(static function ($admin) {
            $admin->id = (string)Uuid::uuid4();
        });
    }

    public function getEmail()
    {
        // TODO: Implement getEmail() method.
    }

    public function getUserId(): string
    {
        return $this->id;
    }

    public function getClassInstance(): Admin
    {
        return $this;
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }
}
