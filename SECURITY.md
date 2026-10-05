# Security Policy

This package is the **Announcement Bar** plugin for
[Inverys CMS](https://github.com/tklmn/inverys-cms). It runs inside the CMS and
inherits the host's security controls (nonce-based CSP, RBAC, CSRF, rate limiting).

## Supported Versions

Security fixes are released for the latest minor version line. Upgrade to the
latest release rather than expecting back-ported patches.

| Version | Supported |
|---------|-----------|
| 1.0.x   | ✅ |
| < 1.0   | ❌ |

## Reporting a Vulnerability

**Please do not open a public issue for security vulnerabilities.**

Report privately via GitHub's coordinated disclosure workflow: the repository's
**Security** tab → **Report a vulnerability**. Include the affected version, impact,
reproduction steps, and any suggested fix. Expect an acknowledgement within
**5 business days**; please allow a reasonable window for a patch before public
disclosure.

## Supply Chain / SBOM

This package has **no third-party runtime dependencies**. A CycloneDX Software Bill
of Materials is published under [`sbom/`](sbom/).
