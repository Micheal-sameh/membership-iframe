<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class MfaRepository
{
    public function findByOdooUserId(int $odooUserId): ?object
    {
        return DB::table('user_roles')
            ->where('odoo_user_id', $odooUserId)
            ->select('odoo_user_id', 'mfa_enabled', 'mfa_secret', 'mfa_enabled_at')
            ->first();
    }

    public function enableMfa(int $odooUserId, string $encryptedSecret): void
    {
        DB::table('user_roles')
            ->where('odoo_user_id', $odooUserId)
            ->update([
                'mfa_enabled' => true,
                'mfa_secret' => $encryptedSecret,
                'mfa_enabled_at' => now(),
            ]);
    }

    public function disableMfa(int $odooUserId): void
    {
        DB::table('user_roles')
            ->where('odoo_user_id', $odooUserId)
            ->update([
                'mfa_enabled' => false,
                'mfa_secret' => null,
                'mfa_enabled_at' => null,
            ]);
    }
}
