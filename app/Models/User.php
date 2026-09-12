<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi secara mass assignment.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Kolom yang disembunyikan ketika model diubah
     * menjadi array atau JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi User dengan Transaction.
     *
     * Satu user dapat menangani banyak transaksi.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function customerProfile()
    {
        return $this->hasOne(Customer::class);
    }

    /**
     * Mengecek apakah user memiliki role tertentu.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Mengecek apakah user adalah Admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Mengecek apakah user adalah Pemilik.
     */
    public function isPemilik(): bool
    {
        return $this->role === 'pemilik';
    }

    /**
     * Mengecek apakah user adalah Admin Penjualan.
     */
    public function isAdminPenjualan(): bool
    {
        return $this->role === 'admin_penjualan';
    }

    /**
     * Mengecek apakah user adalah Customer.
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }
}