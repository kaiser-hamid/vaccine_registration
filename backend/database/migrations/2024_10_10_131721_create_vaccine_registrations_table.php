<?php

use App\Enum\RegistrationStatusEnum;
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
        Schema::create('vaccine_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('nid')->unique();
            $table->string('status')->default(RegistrationStatusEnum::NOT_SCHEDULED);
            $table->date('vaccination_date')->index()->nullable();

            $table->unsignedBigInteger('vaccine_center_id')->nullable();
            $table->foreign('vaccine_center_id')->references('id')->on('vaccine_centers')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccine_registrations');
    }
};
