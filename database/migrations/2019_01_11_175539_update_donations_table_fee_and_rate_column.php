<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDonationsTableFeeAndRateColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table
                ->decimal('intermediation_fee', 10, 2)
                ->after('donated_amount')
                ->comment('Taxa cobrada pelas operadoras de cartão e repassadas pelo gateway de pagamento - percentual sobre o valor total da transação')
                ->nullable();

            $table
                ->decimal('intermediation_rate', 10, 2)
                ->after('intermediation_fee')
                ->comment('Taxa fixa cobrada pelo gateway de pagamento sobre cada transação')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->removeColumn('intermediation_fee');
            $table->removeColumn('intermediation_rate');
        });
    }
}
