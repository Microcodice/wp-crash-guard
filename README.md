
# WP Crash Guard Complete User Manual

Version 1.4.0

## Table of Contents

1.  [Introduction]
2.  [Key Features
3.  [Installation]
4.  [Configuration]
5.  [Whitelist Management]
6.  [Monitoring & Logs]
7.  [Advanced Settings]
8.  [Use Cases & Best Practices]
9.  [Troubleshooting]
10.  [Technical Details]

## Introduction

WP Crash Guard is a WordPress security and stability plugin that acts as a protective shield for your website. Operating as a "must-use" plugin, it intercepts critical errors before they can crash your site and automatically takes corrective action by deactivating the problematic plugin or theme.

### Why WP Crash Guard?

-   **Zero Downtime**: Your site remains accessible even when a plugin fails
-   **Automatic Recovery**: No manual intervention required
-   **Smart Detection**: Identifies the exact plugin causing issues
-   **Flexible Response**: Customizable behavior for different scenarios
-   **Complete Transparency**: Detailed logging of all actions

## Key Features

### Core Protection Features

-   **Fatal Error Interception**: Catches PHP fatal errors, parse errors, and compile errors
-   **Memory Management**: Handles out-of-memory errors with emergency recovery
-   **Exception Handling**: Manages uncaught exceptions that would normally crash the site
-   **Intelligent Plugin Identification**: Pinpoints the exact plugin causing the error

### User Experience Features

-   **Customizable Visitor Experience**: 5 different modes for handling errors on the frontend
-   **Admin Notification Options**: 4 different ways to notify administrators
-   **Whitelist System**: Exclude trusted plugins from monitoring
-   **Multi-language Support**: Full internationalization support

### Developer Features

-   **Dry Run Mode**: Test without actually deactivating plugins
-   **Configurable Error Levels**: Choose which PHP errors trigger protection
-   **Comprehensive Logging**: Detailed error and action logs
-   **Must-Use Architecture**: Loads before all other plugins for maximum protection

## Installation

### Automatic Installation

1.  Download the latest WP Crash Guard installer package
2.  Log into your WordPress admin panel
3.  Navigate to **Plugins → Add New → Upload Plugin**
4.  Select the downloaded ZIP file and click **Install Now**
5.  Click **Activate Plugin** when prompted

### What Happens During Installation

1.  The installer creates the `mu-plugins` directory if it doesn't exist
2.  Copies all plugin files to `mu-plugins/wp-crash-guard/`
3.  Creates a loader file `wp-crash-guard-loader.php` in `mu-plugins`
4.  Deactivates and removes itself automatically
5.  Redirects you to the plugin list

### Post-Installation

After installation, WP Crash Guard will:

-   No longer appear in your regular plugins list
-   Be visible under **Plugins → Must-Use**
-   Show a new menu item **Crash Guard** in your admin panel

## Configuration

### Accessing Settings

Navigate to **Crash Guard → Settings** in your WordPress admin panel.

### Visitor Behavior Settings

Configure how your site responds to errors for regular visitors:

#### Do Nothing (Silent Mode)

-   **What happens**: Plugin is deactivated silently, page reloads automatically
-   **User sees**: Nothing - the page simply refreshes
-   **Best for**: Sites where user experience is paramount
-   **Note**: Most transparent option

#### Automatically Reload

-   **What happens**: Shows a loading screen, then reloads after delay
-   **User sees**: "Updating..." message with countdown
-   **Best for**: Sites where brief interruptions are acceptable
-   **Customizable**: Set delay from 0-60 seconds

#### Show Maintenance Page

-   **What happens**: Displays professional maintenance page
-   **User sees**: "Maintenance in progress" message
-   **Best for**: Professional sites, e-commerce
-   **HTTP Status**: Returns 503 Service Unavailable

#### Show Custom Message

-   **What happens**: Displays your custom HTML content
-   **User sees**: Your personalized message
-   **Best for**: Branded experiences, specific instructions
-   **Supports**: Full HTML including styles

#### Stealth Mode

-   **What happens**: Instant redirect with no intermediate page
-   **User sees**: Page flickers and reloads
-   **Best for**: Maximum speed recovery
-   **Note**: May be jarring for users

### Administrator Behavior Settings

Configure notifications for logged-in administrators:

#### Show Full Error Details

-   **What shows**: Complete error page with technical details
-   **Information**: Error message, file path, line number
-   **Best for**: Development environments
-   **Note**: Blocks page until acknowledged

#### Show Toast Notification

-   **What shows**: Small popup in top-right corner
-   **Duration**: 5 seconds (extendable on hover)
-   **Best for**: Production sites with active admins
-   **Non-blocking**: Can continue working

#### Automatically Reload

-   **What happens**: Page refreshes with dashboard notice
-   **Best for**: Admins who want minimal interruption
-   **Combines**: Auto-recovery with notification

#### Show Nothing

-   **What happens**: Complete silence, check logs later
-   **Best for**: Production sites with monitoring
-   **Note**: Only dashboard notices appear

## Whitelist Management

### Accessing the Whitelist

Navigate to **Crash Guard** and click the **Whitelist** tab.

### Understanding the Whitelist

The whitelist allows you to exclude specific plugins from WP Crash Guard monitoring. Whitelisted plugins:

-   Will never be deactivated by WP Crash Guard
-   Continue to be loaded even if they cause errors
-   Are your responsibility to monitor

### When to Use Whitelist

Add plugins to the whitelist when:

-   **Development/Debug plugins**: Query Monitor, Debug Bar
-   **Testing plugins**: Intentionally cause errors
-   **Critical plugins**: Must run despite occasional warnings
-   **Special behavior plugins**: Custom error handlers

### Managing Whitelisted Plugins

1.  **Search Function**: Type to filter plugins instantly
2.  **Status Indicators**: Shows active/inactive state
3.  **Bulk Selection**: Check multiple plugins at once
4.  **Save Changes**: Click "Save Whitelist" to apply

### Best Practices

-   Only whitelist plugins you trust completely
-   Regularly review your whitelist
-   Remove plugins from whitelist when no longer needed
-   Document why each plugin is whitelisted

## Monitoring & Logs

### Recent Errors Tab

View all intercepted errors with detailed information:

#### Information Displayed

-   **Plugin Name**: Which plugin caused the error
-   **Error Message**: The PHP error description
-   **File Location**: Exact file and line number
-   **Timestamp**: When the error occurred
-   **User**: Who was logged in when it happened

#### Special Indicators

-   **Memory Errors**: Shows warning about PHP memory limit
-   **Repeated Errors**: Groups similar errors together

### Action Log Tab

Track all WP Crash Guard actions:

#### Logged Actions

-   **Plugin Activations**: When plugins are activated
-   **Automatic Deactivations**: When WP Crash Guard intervenes
-   **Manual Actions**: Admin-initiated changes

#### Log Management

-   **Clear Logs**: Remove old entries
-   **Export**: Copy data for external analysis
-   **Retention**: Last 100 actions kept automatically

## Advanced Settings

### Error Interception Threshold

Choose which PHP errors trigger protection:

#### Fatal Errors Only (Default)

-   **Catches**: E_ERROR, E_PARSE, E_COMPILE_ERROR
-   **Ignores**: Warnings, notices, deprecations
-   **Best for**: Production sites
-   **Safety**: Highest - only critical errors

#### Warnings & Above

-   **Catches**: All above + E_WARNING
-   **Use case**: Staging environments
-   **Risk**: May deactivate for non-critical issues

#### Notices & Above

-   **Catches**: Almost all PHP errors
-   **Use case**: Development only
-   **Warning**: High risk of false positives

### Operation Modes

#### Dry Run Mode

-   **Function**: Detect and log without deactivating
-   **Use for**: Testing WP Crash Guard behavior
-   **Shows**: What would happen without doing it
-   **Safe for**: Production testing

#### Auto-Deactivation Toggle

-   **Enabled**: Problematic plugins are deactivated
-   **Disabled**: Only logging, no action taken
-   **Warning**: Disabling may leave site broken

#### Error Logging

-   **Enabled**: All errors saved to database
-   **Disabled**: No error history kept
-   **Performance**: Minimal impact when enabled

### Reload Delay

-   **Range**: 0-60 seconds
-   **Default**: 5 seconds
-   **0 seconds**: Instant reload
-   **Higher values**: Give users time to read messages

### Custom Messages

Create personalized error pages:

```html
<div style="text-align: center; padding: 50px;">
  <h1>We'll be right back!</h1>
  <p>Our team is updating the site. Please try again in a moment.</p>
  <p>Questions? Email: support@example.com</p>
</div>

```

## Use Cases & Best Practices

### Development Environment

**Recommended Settings**:

-   Admin Mode: Show full error details
-   Visitor Mode: Do nothing
-   Error Level: Notices & Above
-   Dry Run: Enabled initially
-   Whitelist: Development tools

### Staging Environment

**Recommended Settings**:

-   Admin Mode: Toast notification
-   Visitor Mode: Maintenance page
-   Error Level: Warnings & Above
-   Dry Run: Disabled
-   Reload Delay: 3 seconds

### Production Environment

**Recommended Settings**:

-   Admin Mode: Show nothing
-   Visitor Mode: Do nothing (stealth)
-   Error Level: Fatal Errors only
-   Dry Run: Disabled
-   Whitelist: Minimal

### E-Commerce Sites

**Special Considerations**:

-   Use "Do nothing" for visitors (no cart interruption)
-   Enable comprehensive logging
-   Set up external monitoring
-   Custom message with support contact

### Membership Sites

**Recommended approach**:

-   Maintenance page with login link
-   Toast notifications for admins
-   Whitelist membership plugins carefully
-   Quick reload delays (2-3 seconds)

## Troubleshooting

### Common Issues

#### Plugin Not Visible After Installation

-   **Check**: Must-Use plugins page
-   **Location**: `/wp-content/mu-plugins/`
-   **Solution**: Installation successful, working as intended

#### Errors Still Showing

-   **Check**: Error threshold settings
-   **Check**: Plugin not in whitelist
-   **Check**: Dry run mode not enabled
-   **Solution**: Verify error type matches threshold

#### Plugin Deactivated Unexpectedly

-   **Check**: Recent Errors log
-   **Check**: Error threshold too low
-   **Solution**: Adjust threshold or whitelist plugin

#### Memory Errors Recurring

-   **Issue**: PHP memory limit too low
-   **Solution**: Increase `memory_limit` in php.ini
-   **Temporary**: WP Crash Guard increases to 256MB on error

### Advanced Troubleshooting

#### Debug Mode

Add to `wp-config.pdf`:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

```

#### Check Must-Use Loading

1.  FTP to `/wp-content/mu-plugins/`
2.  Verify `wp-crash-guard-loader.php` exists
3.  Check `wp-crash-guard/` directory present

#### Manual Deactivation

If needed, delete via FTP:

-   `/wp-content/mu-plugins/wp-crash-guard-loader.php`
-   `/wp-content/mu-plugins/wp-crash-guard/`

## Technical Details

### Architecture

WP Crash Guard uses WordPress's must-use plugin system:

-   Loads before all regular plugins
-   Cannot be deactivated from admin
-   Survives plugin conflicts

### Error Handling Flow

1.  **Error Occurs**: PHP generates fatal error
2.  **Interception**: Shutdown handler catches error
3.  **Identification**: Traces error to specific plugin
4.  **Whitelist Check**: Skips if plugin is whitelisted
5.  **Logging**: Records error details
6.  **Action**: Sets transient for deactivation
7.  **Recovery**: Redirects based on settings
8.  **Cleanup**: Deactivates plugin on next load

### Performance Considerations

-   **Memory Usage**: ~1MB baseline
-   **CPU Impact**: Negligible except during errors
-   **Database Queries**: 2-3 per error event
-   **Page Load**: No measurable impact

### Security Features

-   **Nonce Verification**: All admin actions protected
-   **Capability Checks**: Requires `manage_options`
-   **Data Sanitization**: All inputs filtered
-   **SQL Injection Protection**: Prepared statements

### Compatibility

-   **WordPress**: 5.0+ required
-   **PHP**: 7.2+ recommended
-   **MySQL**: 5.6+ required
-   **Multisite**: Fully supported

### File ZIP Structure

```
/wp-crash-guard.zip/
├── wp-crash-guard-installer.php
└── plugin-files/
    ├── wp-crash-guard.php
    ├── readme.md
    ├── readme-italian.md
    └── languages/
	    ├── wp-crash-guard.pot
        ├── wp-crash-guard-it_IT.mo
        └── wp-crash-guard-it_IT.po

```

----------

**Version**: 1.4.0  
**Author**: Microcodice  
**License**: GPL v2 or later  
**Support**: [GitHub Issues](https://github.com/microcodice/wp-crash-guard)
