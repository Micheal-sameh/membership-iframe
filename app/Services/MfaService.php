<?php

namespace App\Services;

use App\Repositories\MfaRepository;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use PragmaRX\Google2FA\Google2FA;

class MfaService
{
    private Google2FA $google2fa;

    public function __construct(
        private MfaRepository $repository,
    ) {
        $this->google2fa = new Google2FA();
    }

    public function generateSecret(): string
    {
        return $this->google2fa->generateSecretKey();
    }

    public function getQrCodeSvg(string $appName, string $email, string $secret): string
    {
        $otpauthUrl = $this->google2fa->getQRCodeUrl($appName, $email, $secret);

        $renderer = new ImageRenderer(
            new RendererStyle(250),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);

        return $writer->writeString($otpauthUrl);
    }

    public function verify(string $secret, string $otp): bool
    {
        return (bool) $this->google2fa->verifyKey($secret, $otp);
    }

    public function isEnabled(int $userId): bool
    {
        $row = $this->repository->findByUserId($userId);

        return $row && $row->mfa_enabled;
    }

    public function getSecret(int $userId): ?string
    {
        $row = $this->repository->findByUserId($userId);

        if (!$row || !$row->mfa_secret) {
            return null;
        }

        return decrypt($row->mfa_secret);
    }

    public function enable(int $userId, string $secret): void
    {
        $this->repository->enableMfa($userId, encrypt($secret));
    }

    public function disable(int $userId): void
    {
        $this->repository->disableMfa($userId);
    }
}
