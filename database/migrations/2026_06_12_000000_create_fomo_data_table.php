<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fomo_data', function (Blueprint $table) {
            $table->id();
            $table->string('fake_name');
            $table->string('fake_city');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fomo_data');
    }
};
