<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Subcontractor and supplier prequalification.
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 20)->unique();
            $table->string('status', 20)->default('new')->index();
            $table->string('type', 20);
            $table->string('company_name', 160);
            $table->string('trading_as', 160)->nullable();
            $table->string('trn', 11);
            $table->string('company_number', 40)->nullable();
            $table->unsignedSmallInteger('year_established')->nullable();
            $table->string('address', 240);
            $table->string('parish', 40);
            $table->string('contact_name', 120);
            $table->string('contact_role', 120)->nullable();
            $table->string('email');
            $table->string('phone', 30);
            $table->string('phone_digits', 20)->nullable()->index();
            $table->json('trades');
            $table->json('parishes_served')->nullable();
            $table->string('employees', 20)->nullable();
            $table->string('registration_grade', 120)->nullable();
            $table->text('experience')->nullable();
            $table->text('message')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('consented_at')->nullable();
            $table->timestamp('status_changed_at')->nullable();
            $table->string('source_url', 300)->nullable();
            $table->timestamps();
        });

        Schema::create('vendor_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->string('kind', 20); // tcc | registration | insurance | other
            $table->string('path');
            $table->string('original_name', 200);
            $table->string('mime', 120)->nullable();
            $table->unsignedInteger('size')->default(0);
            $table->string('number', 80)->nullable();
            $table->date('expires_on')->nullable()->index();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reminded_at')->nullable();
            $table->timestamp('superseded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_documents');
        Schema::dropIfExists('vendors');
    }
};
