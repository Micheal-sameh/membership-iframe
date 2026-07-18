<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class MfaRepository
{
    public function findByUserId(int $userId): ?object
    {
        return DB::table('users')
            ->where('id', $userId)
            ->select('id', 'mfa_enabled', 'mfa_secret', 'mfa_enabled_at')
            ->first();
    }

    public function enableMfa(int $userId, string $encryptedSecret): void
    {
        DB::table('users')
            ->where('id', $userId)
            ->update([
                'mfa_enabled' => true,
                'mfa_secret' => $encryptedSecret,
                'mfa_enabled_at' => now(),
            ]);
    }

    public function disableMfa(int $userId): void
    {
        DB::table('users')
            ->where('id', $userId)
            ->update([
                'mfa_enabled' => false,
                'mfa_secret' => null,
                'mfa_enabled_at' => null,
            ]);
    }
}
