<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf', 25)->after('password')->nullable();
            $table->string('street_number')->after('cpf')->nullable();
            $table->string('street_name')->after('street_number')->nullable();
            $table->string('district')->after('street_name')->nullable();
            $table->string('postal_code')->after('district')->nullable();
            $table->string('city')->after('postal_code')->nullable();
            $table->string('state')->after('city')->nullable();
            $table->string('complement')->after('state')->nullable();
            $table->string('area_code')->after('complement')->nullable();
            $table->string('phone_number')->after('area_code')->nullable();
            $table->smallInteger('registration_completed')->after('remember_token')->default(0);
            $table->smallInteger('is_admin')->after('registration_completed')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table
                ->removeColumn('street_number')
                ->removeColumn('street_name')
                ->removeColumn('district')
                ->removeColumn('postal_code')
                ->removeColumn('city')
                ->removeColumn('state')
                ->removeColumn('complement')
                ->removeColumn('area_code')
                ->removeColumn('phone_number')
                ->removeColumn('registration_completed')
                ->removeColumn('is_admin');
        });
    }
}
