<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nome da role (ex.: Admin, Editor, Viewer)
            $table->string('slug'); // ex.: admin, editor, viewer
            $table->timestamps();

            // índice único composto
            $table->unique(['company_id', 'slug']);
        });


        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role'); // remover a string antiga
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            $table->string('role')->nullable(); // volta para string se fizer rollback
        });

        Schema::dropIfExists('roles');
    }
};
