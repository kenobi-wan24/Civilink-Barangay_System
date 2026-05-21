<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Account status — default 'active' so existing admin/staff/captain
            // accounts are completely unaffected by this migration.
            $table->enum('account_status', ['pending', 'active', 'rejected'])
                  ->default('active')
                  ->after('is_active');

            // Stored when admin rejects a registration. Shown to resident on login.
            $table->text('rejection_reason')->nullable()->after('account_status');

            // Personal info fields — only filled for resident self-registrations.
            // Nullable so existing records don't break.
            $table->string('first_name', 100)->nullable()->after('rejection_reason');
            $table->string('middle_name', 100)->nullable()->after('first_name');
            $table->string('last_name', 100)->nullable()->after('middle_name');
            $table->string('suffix', 20)->nullable()->after('last_name');
            $table->date('birthdate')->nullable()->after('suffix');
            $table->string('reg_gender', 20)->nullable()->after('birthdate');
            $table->string('reg_civil_status', 30)->nullable()->after('reg_gender');
            $table->string('reg_contact', 20)->nullable()->after('reg_civil_status');
            $table->string('reg_purok_zone', 100)->nullable()->after('reg_contact');
            $table->text('reg_address')->nullable()->after('reg_purok_zone');

            // Optional valid ID upload path. Stored under storage/app/public/valid-ids/
            $table->string('valid_id_path')->nullable()->after('reg_address');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'account_status',
                'rejection_reason',
                'first_name',
                'middle_name',
                'last_name',
                'suffix',
                'birthdate',
                'reg_gender',
                'reg_civil_status',
                'reg_contact',
                'reg_purok_zone',
                'reg_address',
                'valid_id_path',
            ]);
        });
    }
};
