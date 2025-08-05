# Urgent Shipping Modules Suite

A comprehensive Magento 2 shipping integration suite for Cargus shipping services, designed for private repository distribution.

## 📦 Package Structure

```
Urgent/
├── composer.json                    # Main metapackage
├── README.md                       # This documentation
├── Base/                          # Foundation module
│   ├── composer.json
│   ├── registration.php
│   ├── etc/module.xml
│   └── ... (module files)
├── Cargus/                        # Basic Cargus shipping
│   ├── composer.json
│   ├── registration.php
│   ├── etc/module.xml
│   └── ... (module files)
├── CargusOldAwb/                  # Old AWB functionality
│   ├── composer.json
│   ├── registration.php
│   ├── etc/module.xml
│   └── ... (module files)
└── CargusShipGo/                  # Advanced Ship & Go
    ├── composer.json
    ├── registration.php
    ├── etc/module.xml
    └── ... (module files)
```

## 🏗️ Module Dependencies

```
Base (Foundation)
├── Cargus (depends on Base)
├── CargusOldAwb (depends on Base)
└── CargusShipGo (depends on Base)
```

## 📋 Individual Modules

### 1. liquidlab-agency/module-base
**Foundation module providing core functionality for all Urgent shipping integrations.**

- **Package Name**: `liquidlab-agency/module-base`
- **Dependencies**: Magento core modules, Laminas components
- **Purpose**: Base classes, utilities, and shared functionality

### 2. liquidlab-agency/module-cargus
**Basic Cargus shipping method integration.**

- **Package Name**: `liquidlab-agency/module-cargus`
- **Dependencies**: `liquidlab-agency/module-base`, Magento shipping modules
- **Purpose**: Core Cargus shipping functionality

### 3. liquidlab-agency/module-cargus-old-awb
**Legacy AWB (Air Waybill) management functionality.**

- **Package Name**: `liquidlab-agency/module-cargus-old-awb`
- **Dependencies**: `liquidlab-agency/module-base`, Magento sales/UI modules
- **Purpose**: Display and manage historical AWB data

### 4. liquidlab-agency/module-cargusshipgo
**Advanced Cargus shipping with Ship & Go functionality.**

- **Package Name**: `liquidlab-agency/module-cargusshipgo`
- **Dependencies**: `liquidlab-agency/module-base`, Magento checkout modules
- **Purpose**: Enhanced shipping options with pickup point selection

## 🚀 Installation Options

### Install Complete Suite (Recommended)
```bash
composer require liquidlab-agency/magento2-urgent-cargus
```

## ⚙️ Configuration Requirements

### PHP Requirements
- **PHP**: ^8.2|^8.3
- **Magento**: 2.4.x compatible

### Magento Module Dependencies
- `magento/framework`: ^103.0
- `magento/module-backend`: ^102.0
- `magento/module-shipping`: ^100.4
- `magento/module-sales`: ^103.0
- Additional modules as specified in individual composer.json files

## 🔧 Post-Installation Steps

### 1. Enable Modules
```bash
bin/magento module:enable Urgent_Base
bin/magento module:enable Urgent_Cargus
bin/magento module:enable Urgent_CargusOldAwb 
bin/magento module:enable Urgent_CargusShipGo
```

### 2. Run Setup
```bash
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy
bin/magento cache:flush
```

### 3. Configure Shipping Methods
Navigate to **Stores > Configuration > Sales > Shipping Methods** and configure the Cargus shipping options.

## 📝 Version Management

### Semantic Versioning
- **Major** (1.x.x): Breaking changes
- **Minor** (x.1.x): New features, backward compatible
- **Patch** (x.x.1): Bug fixes, backward compatible

### Release Process
1. Update version in all `composer.json` files
2. Tag release in repository
3. Update `packages.json` with new version
4. Test installation in clean environment

## 🐛 Troubleshooting

### Common Issues

#### Dependency Resolution
```bash
# Clear composer cache
composer clear-cache

# Update dependencies
composer update liquidlab-agency/magento2-urgent-cargus
```

#### Module Not Found
```bash
# Verify repository configuration
composer config repositories

# Check authentication
composer config --list --global
```

#### Installation Conflicts
```bash
# Check for conflicts
composer why-not liquidlab-agency/magento2-urgent-cargus

# Force reinstall
composer reinstall liquidlab-agency/magento2-urgent-cargus
```

## 📞 Support

For issues related to:
- **Installation**: Check composer configuration and authentication
- **Dependencies**: Verify Magento version compatibility
- **Functionality**: Refer to individual module documentation

## 📄 License

**Proprietary** - All rights reserved. This package is for private use only.

---

**Author**: Alexandru Marinescu (alexandru.marinescu@tremend.com)  
**Version**: 1.0.0  
**Last Updated**: 2025-01-05