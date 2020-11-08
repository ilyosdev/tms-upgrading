<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateTransportTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('transport', function (Blueprint $table) {
                $table->id();
                $table->integer('client_id');
                $table->integer('vehicle_id');
                $table->string('destination', 255);
                $table->string('description', 255);
                $table->integer('tonnes');
                $table->integer('charges');
                $table->text('memo')->nullable();
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
            Schema::drop('transport');
        }

    }
