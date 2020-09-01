<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivationToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('activation_token')->nullable()->comment('email验证token')->after('email_verified_at');
            $table->boolean('is_activated')->index()->default(false)->comment('email是否已验证：0-未验证；1-已验证')->after('activation_token');
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
            $table->dropColumn('activation_token');
            $table->dropColumn('is_activated');
        });
    }
}
