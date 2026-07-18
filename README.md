# Membership Portal

Standalone Laravel project extracted from the `membership` module of the Odoo SSO Reports app.

Provides login, MFA (TOTP), and an iframe portal, served on the domain set by `MEMBERSHIP_DOMAIN`.

## Status

The module's own code (controllers, routes, views, config, `MembershipServiceProvider`) is fully
ported. The following still need to be wired up for login/MFA to work against real data — they were
intentionally left out of this extraction:

- **Auth**: `AuthController`/`MfaController` expect an Auth guard whose user has a `login` property
  and `id`, matching the original app's custom `odoo` guard (`OdooUserProvider` + `OdooUser` model
  backed by Odoo's `res_users` table over a read-only Postgres connection). The default Laravel
  `web` guard + `App\Models\User` is currently in place as a stub.
- **MFA storage**: `MfaRepository` reads/writes `mfa_enabled` / `mfa_secret` / `mfa_enabled_at` on a
  `user_roles` table keyed by `odoo_user_id`. No migration for the base `user_roles` table is
  included — only add the MFA columns once that table exists.
- **Env vars**: `MEMBERSHIP_DOMAIN`, `MEMBERSHIP_IFRAME_URL` are in `.env` as placeholders.

## Module layout

- `app/Modules/Membership/` — controllers, routes, config, service provider
- `app/Http/Middleware/MembershipAuthenticated.php`, `SetLocale.php`
- `app/Services/MfaService.php`, `app/Repositories/MfaRepository.php`
- `resources/views/membership/`
