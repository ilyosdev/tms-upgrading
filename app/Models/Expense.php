<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Expense extends Model
    {
        protected $fillable = ['description', 'memo', 'amount', 'quantity'];


        // Get all payments

        public static function cashInHand()
        {
            return self::getAllPayments()->amount - self::getAllExpenses();

        }

        public static function getAllPayments()
        {
            $payments = DB::table('payments')
                ->select(DB::raw('sum(amount) AS amount'))->first();

            return $payments ? $payments : 0;
        }

        public static function getAllExpenses()
        {

            $expenses = DB::table('expenses')
                ->select(DB::raw('sum(amount*quantity) as amount'))->first();

//            return $expenses->amount ? $expenses->amount : 0;
            return $expenses->amount ?: 0;
        }


    }
