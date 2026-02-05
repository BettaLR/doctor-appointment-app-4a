<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->after('id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('blood_type_id')
                ->nullable()
                ->after('user_id')
                ->constrained('blood_types')
                ->onDelete('set null');

            $table->string('allergies')->nullable();
            $table->string('chronic_conditions')->nullable();
            $table->string('surgical_history')->nullable();
            $table->string('family_history')->nullable();
            $table->string('observations')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['blood_type_id']);
            $table->dropColumn([
                'user_id',
                'blood_type_id',
                'allergies',
                'chronic_conditions',
                'surgical_history',
                'family_history',
                'observations',
                'emergency_contact_name',
                'emergency_contact_phone',
                'emergency_contact_relationship',
            ]);
        });
    }
};
