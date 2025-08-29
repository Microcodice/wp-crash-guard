<?php
/*
Plugin Name: WP Crash Guard Installer
Description: Installs WP Crash Guard as a Must-Use plugin
Version: 1.0.0
Author: Microcodice
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Activation hook
register_activation_hook(__FILE__, 'wp_crash_guard_installer_activate');

function wp_crash_guard_installer_activate() {
    // Redirect to installation page after activation
    set_transient('wp_crash_guard_installer_redirect', true, 30);
}

// Handle redirect after activation
add_action('admin_init', 'wp_crash_guard_installer_redirect');

function wp_crash_guard_installer_redirect() {
    if (get_transient('wp_crash_guard_installer_redirect')) {
        delete_transient('wp_crash_guard_installer_redirect');
        wp_redirect(admin_url('tools.php?page=wp-crash-guard-installer'));
        exit;
    }
}

// Add admin menu
add_action('admin_menu', 'wp_crash_guard_installer_menu');

function wp_crash_guard_installer_menu() {
    add_management_page(
        'WP Crash Guard Installer',
        'WP Crash Guard Installer',
        'manage_options',
        'wp-crash-guard-installer',
        'wp_crash_guard_installer_page'
    );
}

// Show admin notices
add_action('admin_notices', 'wp_crash_guard_installer_notices');

function wp_crash_guard_installer_notices() {
    $notices = get_transient('wp_crash_guard_installer_notices');
    if ($notices) {
        foreach ($notices as $notice) {
            $class = $notice['type'] === 'error' ? 'notice-error' : 'notice-success';
            echo '<div class="notice ' . $class . ' is-dismissible"><p>' . $notice['message'] . '</p></div>';
        }
        delete_transient('wp_crash_guard_installer_notices');
    }
}

// Installer page
function wp_crash_guard_installer_page() {
    $installer_dir = plugin_dir_path(__FILE__);
    $plugin_files_dir = $installer_dir . 'plugin-files/';
    
    // Look for plugin file (could be .php or renamed)
    $plugin_file = false;
    if (file_exists($plugin_files_dir . 'wp-crash-guard.php')) {
        $plugin_file = 'wp-crash-guard.php';
    } elseif (file_exists($plugin_files_dir . 'wp-crash-guard-php')) {
        $plugin_file = 'wp-crash-guard-php';  // Renamed file without extension
    } elseif (file_exists($plugin_files_dir . 'wp-crash-guard.php.txt')) {
        $plugin_file = 'wp-crash-guard.php.txt';
    }
    
    ?>
    <div class="wrap">
        <h1>WP Crash Guard - Installer</h1>
        
        <div class="card">
            <h2>Must-Use Plugin Installation</h2>
            
            <?php if (!$plugin_file): ?>
                <div class="notice notice-error inline">
                    <p>Plugin files not found in <code>plugin-files/</code> directory. Please ensure the package structure is correct.</p>
                </div>
            <?php else: ?>
                <p>Found: <code><?php echo esc_html($plugin_file); ?></code></p>
                
                <?php if (isset($_GET['install']) && $_GET['install'] === 'true'): ?>
                    <?php wp_crash_guard_do_install(); ?>
                <?php else: ?>
                    <p>This installer will perform the following operations:</p>
                    <p><code><?php echo esc_html(WPMU_PLUGIN_DIR); ?>/wp-crash-guard/</code></p>
                    
                    <p>
                        <a href="<?php echo admin_url('tools.php?page=wp-crash-guard-installer&install=true'); ?>" 
                           class="button button-primary"
                           onclick="return confirm('Proceed with installation?');">
                            Install Now
                        </a>
                    </p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

// Installation function
function wp_crash_guard_do_install() {
    $installer_dir = plugin_dir_path(__FILE__);
    $source_dir = $installer_dir . 'plugin-files/';
    $mu_plugins_dir = WPMU_PLUGIN_DIR;
    $dest_dir = $mu_plugins_dir . '/wp-crash-guard';
    
    // Create mu-plugins if it doesn't exist
    if (!file_exists($mu_plugins_dir)) {
        wp_mkdir_p($mu_plugins_dir);
        echo '<p>✓ Created mu-plugins directory</p>';
    }
    
    // Backup if already exists
    if (file_exists($dest_dir)) {
        $backup = $dest_dir . '_backup_' . time();
        rename($dest_dir, $backup);
        echo '<p>✓ Backup created</p>';
    }
    
    // Create destination directory
    wp_mkdir_p($dest_dir);
    
    // Copy files
    $copied = wp_crash_guard_copy_directory($source_dir, $dest_dir);
    
    if ($copied) {
        echo '<p>✓ Files copied</p>';
        
        // Create loader with translation support
        $loader_content = "<?php\n";
        $loader_content .= "// WP Crash Guard Loader\n";
        $loader_content .= "if (file_exists(WPMU_PLUGIN_DIR . '/wp-crash-guard/wp-crash-guard.php')) {\n";
        $loader_content .= "    require_once WPMU_PLUGIN_DIR . '/wp-crash-guard/wp-crash-guard.php';\n";
        $loader_content .= "}\n\n";
        $loader_content .= "// Force translation loading for mu-plugin\n";
        $loader_content .= "add_action('init', function() {\n";
        $loader_content .= "    // First unload any previous translations\n";
        $loader_content .= "    unload_textdomain('wp-crash-guard');\n";
        $loader_content .= "    \n";
        $loader_content .= "    // Then load from correct path\n";
        $loader_content .= "    \$locale = get_locale();\n";
        $loader_content .= "    \$mo_file = WPMU_PLUGIN_DIR . '/wp-crash-guard/languages/wp-crash-guard-' . \$locale . '.mo';\n";
        $loader_content .= "    \n";
        $loader_content .= "    if (file_exists(\$mo_file)) {\n";
        $loader_content .= "        load_textdomain('wp-crash-guard', \$mo_file);\n";
        $loader_content .= "    }\n";
        $loader_content .= "}, -10); // High priority to load before plugin\n";
        
        file_put_contents($mu_plugins_dir . '/wp-crash-guard-loader.php', $loader_content);
        echo '<p>✓ Loader created</p>';
        
        // Deactivate installer
        deactivate_plugins(plugin_basename(__FILE__));
        
        // Delete installer
        wp_crash_guard_delete_installer();
        
        echo '<div class="notice notice-success inline">';
        echo '<p><strong>Installation complete!</strong></p>';
        echo '<p>The installer has been automatically removed.</p>';
        echo '<p><a href="' . admin_url('plugins.php') . '">Back to plugins</a></p>';
        echo '</div>';
        
    } else {
        echo '<div class="notice notice-error inline">';
        echo '<p>Error copying files</p>';
        echo '</div>';
    }
}

// Helper function to copy directory
function wp_crash_guard_copy_directory($src, $dst) {
    if (!is_dir($src)) {
        return false;
    }
    
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }
    
    $dir = opendir($src);
    while (($file = readdir($dir)) !== false) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        
        $src_file = $src . '/' . $file;
        $dst_file = $dst . '/' . $file;
        
        // If it's a .php.txt file, rename to .php
        if (substr($file, -8) === '.php.txt') {
            $dst_file = $dst . '/' . substr($file, 0, -4);
        }
        // If it's wp-crash-guard-php (without extension), rename to .php
        elseif ($file === 'wp-crash-guard-php') {
            $dst_file = $dst . '/wp-crash-guard.php';
        }
        
        if (is_dir($src_file)) {
            wp_crash_guard_copy_directory($src_file, $dst_file);
        } else {
            copy($src_file, $dst_file);
        }
    }
    
    closedir($dir);
    return true;
}

// Function to delete installer
function wp_crash_guard_delete_installer() {
    $installer_dir = plugin_dir_path(__FILE__);
    
    // Recursively delete all files and folders
    wp_crash_guard_delete_directory($installer_dir);
}

// Helper function to recursively delete directory
function wp_crash_guard_delete_directory($dir) {
    if (!is_dir($dir)) {
        return;
    }
    
    $files = array_diff(scandir($dir), array('.', '..'));
    
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        
        if (is_dir($path)) {
            wp_crash_guard_delete_directory($path);
        } else {
            unlink($path);
        }
    }
    
    rmdir($dir);
}