<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreatePaymentsTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('payments', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('client_id');
                $table->integer('amount');
                $table->string('mode');
                $table->string('chequeName')->nullable();
                $table->bigInteger('chequeNumber')->nullable()->unique();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::drop('payments');
        }

    }
