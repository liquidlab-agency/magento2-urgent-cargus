# Urgent Cargus for Magento 2

Community-maintained **Cargus** shipping integration for Magento 2. This is a
composer metapackage bundling four modules — `Urgent_Base`, `Urgent_Cargus`,
`Urgent_CargusOldAwb`, `Urgent_CargusShipGo` — updated for **Magento 2.4.x** and
**PHP 8.2 / 8.3**.

> ⚠️ **Not affiliated with Cargus or Tremend.** This is an independent fork
> maintained by [LiquidLab](https://github.com/liquidlab-agency). See
> [Origin & attribution](#-origin--attribution) and [License](#-license) below.

## 🧭 Origin & attribution

This package is a maintained fork of the original **"Cargus for Magento 2"** module:

- **Original source:** <https://gitlab.com/cargus/cargus-modules/magento2>
- **Original author:** Alexandru Marinescu
- **Original copyright:** © Tremend Software Consulting

The upstream module had not been updated to keep pace with current Magento 2.4.x /
PHP 8.2+ requirements. LiquidLab maintains this fork independently to restore
compatibility and ship fixes. **All rights to the original work remain with its
copyright holders (Tremend Software Consulting / Cargus); LiquidLab does not claim
ownership of the original code.** See the [`NOTICE`](NOTICE) file for full attribution.

## 🔧 What this fork changes

- Repackaged as a composer metapackage (`Base` / `Cargus` / `CargusOldAwb` / `CargusShipGo`)
- Magento 2.4.x + PHP 8.2 / 8.3 compatibility (Laminas fixes)
- Fixed Cargus AWB saving
- Cities loaded via API through a frontend controller (instead of client-side AJAX)
- QR-code generation fix
- Added A4 / A6 AWB printing
- Security hardening of admin actions and config-key storage

## 📦 Package structure

```
magento2-urgent-cargus/
├── composer.json            # Metapackage (liquidlab-agency/magento2-urgent-cargus)
└── src/
    ├── Base/                # Foundation module   → liquidlab-agency/module-base
    ├── Cargus/              # Basic Cargus shipping → liquidlab-agency/module-cargus
    ├── CargusOldAwb/        # Legacy AWB management → liquidlab-agency/module-cargus-old-awb
    └── CargusShipGo/        # Ship & Go pickup points → liquidlab-agency/module-cargusshipgo
```

**Dependencies:** `Cargus`, `CargusOldAwb`, and `CargusShipGo` each depend on `Base`.

## 🚀 Installation

If the package is available on Packagist:

```bash
composer require liquidlab-agency/magento2-urgent-cargus
```

Otherwise, add the repository first (installs straight from GitHub):

```bash
composer config repositories.urgent-cargus vcs https://github.com/liquidlab-agency/magento2-urgent-cargus
composer require liquidlab-agency/magento2-urgent-cargus
```

## ⚙️ Post-installation

```bash
bin/magento module:enable Urgent_Base Urgent_Cargus Urgent_CargusOldAwb Urgent_CargusShipGo
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy
bin/magento cache:flush
```

Then configure the carriers under **Stores → Configuration → Sales → Shipping Methods**.

### Requirements

- PHP `^8.2 | ^8.3`
- Magento `2.4.x` (`magento/framework: ^103.0`)

## 🆘 Support

Report issues at
<https://github.com/liquidlab-agency/magento2-urgent-cargus/issues>.

## 📄 License

This repository is distributed as a **maintained fork**. The original module is
published **without an explicit license**, so all rights to the original work remain
with **Tremend Software Consulting / Cargus**. LiquidLab does not own the underlying
copyright and cannot grant a license to it; LiquidLab's own modifications are provided
**"as is", without warranty of any kind**. If you intend to use, copy, or redistribute
this software, obtain permission from the original copyright holders.

See [`LICENSE`](LICENSE) and [`NOTICE`](NOTICE) for details.

---

Maintained by [LiquidLab](https://github.com/liquidlab-agency) · Original module
© Tremend Software Consulting (Alexandru Marinescu).
