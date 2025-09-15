<?php

// database/migrations/xxxx_xx_xx_create_link_clicks_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('link_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained()->onDelete('cascade');

            // Localização aproximada (baseada em IP → GeoIP lite, sem precisão)
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();

            // Dispositivo
            $table->enum('device', ['desktop', 'smartphone', 'tablet'])->nullable();

            // Sistema operacional / navegador
            $table->string('os')->nullable();
            $table->string('os_version')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();

            // Idioma do navegador
            $table->string('language', 10)->nullable();

            // Fonte do acesso (referer)
            $table->string('referrer')->nullable();

            // Data/hora do clique
            $table->timestamp('clicked_at')->useCurrent();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('link_clicks');
    }
};
