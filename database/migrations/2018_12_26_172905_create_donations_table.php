<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'FK_donations_users_id')->references('id')->on('users');
            $table->unsignedInteger('campaign_id');
            $table->foreign('campaign_id', 'FK_donations_campaigns_id')->references('id')->on('campaigns');
            $table->decimal('donated_amount', 10);
            $table->decimal('received_amount', 10)->nullable();
            $table->timestamp('created_at', 0)->nullable();
            $table->integer('created_by');
            $table->timestamp('updated_at', 0)->nullable();
            $table->integer('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations');
    }
}
