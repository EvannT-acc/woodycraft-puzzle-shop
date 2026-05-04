<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // On corrige mode_paiement : la migration originale utilisait boolean,
    // on a besoin d'une chaine de caracteres (cheque, paypal, carte)
    public function up(): void
    {
        Schema::table('paniers', function (Blueprint $table) {
            $table->string('mode_paiement', 20)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('paniers', function (Blueprint $table) {
            $table->boolean('mode_paiement')->nullable()->change();
        });
    }
};