<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->boolean('mfa_enabled')->default(false)->after('role_id');
            $table->text('mfa_secret')->nullable()->after('mfa_enabled');
            $table->timestamp('mfa_enabled_at')->nullable()->after('mfa_secret');
        });
    }

    public function down(): void
    {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->dropColumn(['mfa_enabled', 'mfa_secret', 'mfa_enabled_at']);
        });
    }
};
