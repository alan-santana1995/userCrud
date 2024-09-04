<?php

use App\Domain\User\Enum\UfEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('last_name', 255);
            $table->string('email')->unique();
            $table->string('document')->unique();
            $table->date('birth_date');
            $table->string('phone_number', 11);
            $table->string('zip_code', 7);
            $table->enum('uf', UfEnum::valuesToArray());
            $table->string('city', 100);
            $table->string('neighborhood', 100);
            $table->string('address', 100);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
