<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Client extends Model
    {
        protected $table = 'clients';

        protected $fillable = ['name', 'phone', 'address'];

        //protected $client = $this;

        public function transport()
        {

            return $this->hasMany('App\Models\Transport');
        }

        public function payment()
        {

            return $this->hasMany('App\Models\Payment');

        }

        public function balance()
        {
            return $this->allCharges()->charges - $this->allPayments();
        }

        public function allCharges()
        {
            return DB::table('transport')
                ->select(DB::raw('sum(tonnes*charges) AS charges'))
                ->where('client_id', $this->id)->first();
        }

        public function allPayments()
        {
            return $this->payment->sum('amount');
        }

    }
