<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Invitations to tender / requests for quotation sent in by procuring entities.
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 20)->unique();
            $table->string('status', 20)->default('new')->index();
            $table->string('sector', 20); // public | private
            $table->string('entity_name', 160);
            $table->string('contact_name', 120);
            $table->string('contact_role', 120)->nullable();
            $table->string('email');
            $table->string('phone', 30);
            $table->string('phone_digits', 20)->nullable()->index();
            $table->string('title', 200);
            $table->string('their_reference', 80)->nullable();
            $table->string('method', 20);
            $table->string('parish', 40)->nullable();
            $table->string('location', 160)->nullable();
            $table->text('scope');
            $table->string('estimated_value', 80)->nullable();
            $table->dateTime('submission_due_at')->index();
            $table->date('clarification_due_on')->nullable();
            $table->dateTime('site_visit_at')->nullable();
            $table->boolean('bid_security')->default(false);
            $table->string('documents_url', 300)->nullable();
            $table->text('message')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('status_changed_at')->nullable();
            $table->string('source_url', 300)->nullable();
            $table->timestamps();
        });

        Schema::create('tender_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('original_name', 200);
            $table->string('mime', 120)->nullable();
            $table->unsignedInteger('size')->default(0);
            $table->timestamps();
        });

        // One timeline for every record (tenders, vendors, applications, enquiries, document rooms).
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->morphs('subject');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('kind', 20)->default('note'); // note | status | assign | system | file
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
        Schema::dropIfExists('tender_files');
        Schema::dropIfExists('tenders');
    }
};
