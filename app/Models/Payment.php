<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Payment extends Model
    {
        protected $table = 'payments';

        protected $fillable = ['client_id', 'amount', 'mode', 'chequeName', 'chequeNumber'];

        public static function fetchAll()
        {
            return DB::table('payments')
                ->join('clients', 'clients.id', '=', 'payments.client_id')
                ->select('payments.*', 'clients.clientName')
                ->get();
        }

        public function client()
        {
            return $this->belongsTo(Client::class);
        }
    }
