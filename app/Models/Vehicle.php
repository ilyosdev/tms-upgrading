<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Vehicle extends Model
    {
        protected $table = 'vehicles';

        protected $fillable = ['plateNumber', 'capacity'];

        public function transport()
        {
            return $this->hasMany(Transport::class);
        }

    }
