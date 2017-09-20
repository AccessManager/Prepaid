<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedBigInteger('pin');
            $table->dateTime('generated_on');
            $table->string('name');
            $table->unsignedInteger('sim_sessions');
            $table->unsignedInteger('interim_updates');
            $table->float('price');
            $table->unsignedInteger('validity');
            $table->enum('validity_unit', \AccessManager\Constants\Time::TIME_DURATION_UNITS);
            $table->dateTime('expires_on');
            $table->dateTime('used_on')->nullable();
            $table->unsignedInteger('used_by')->nullable();
            $table->string('method')->nullable();

        });

        Schema::create('voucher_primary_policies', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('voucher_id');
            $table->unsignedInteger('min_up');
            $table->enum('min_up_unit', \AccessManager\Constants\Bandwidth::BANDWIDTH_UNITS );
            $table->unsignedInteger('min_down');
            $table->enum('min_down_unit', \AccessManager\Constants\Bandwidth::BANDWIDTH_UNITS );
            $table->unsignedInteger('max_up');
            $table->enum('max_up_unit', \AccessManager\Constants\Bandwidth::BANDWIDTH_UNITS );
            $table->unsignedInteger('max_down');
            $table->enum('max_down_unit', \AccessManager\Constants\Bandwidth::BANDWIDTH_UNITS );
        });

        Schema::create('voucher_limits', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('voucher_id');
            $table->unsignedInteger('time_limit')->nullable();
            $table->enum('time_unit', \AccessManager\Constants\Time::TIME_LIMIT_UNITS);
            $table->unsignedInteger('data_limit')->nullable();
            $table->enum('data_unit', \AccessManager\Constants\Data::DATA_LIMIT_UNITS);
            $table->unsignedInteger('reset_every');
            $table->enum('reset_every_unit', \AccessManager\Constants\Time::TIME_DURATION_UNITS);
        });

        Schema::create('voucher_aq_policies', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('voucher_id');
            $table->unsignedInteger('min_up');
            $table->enum('min_up_unit', \AccessManager\Constants\Bandwidth::BANDWIDTH_UNITS );
            $table->unsignedInteger('min_down');
            $table->enum('min_down_unit', \AccessManager\Constants\Bandwidth::BANDWIDTH_UNITS );
            $table->unsignedInteger('max_up');
            $table->enum('max_up_unit', \AccessManager\Constants\Bandwidth::BANDWIDTH_UNITS );
            $table->unsignedInteger('max_down');
            $table->enum('max_down_unit', \AccessManager\Constants\Bandwidth::BANDWIDTH_UNITS );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_aq_policies');
        Schema::dropIfExists('voucher_limits');
        Schema::dropIfExists('voucher_primary_policies');
        Schema::dropIfExists('vouchers');

    }
}
