# WP Crash Guard Detailed User Manual

WP Crash Guard is a "must-use" WordPress plugin designed to prevent website crashes caused by faulty plugins or themes. It proactively intercepts critical errors and automatically deactivates the problematic component, ensuring instant site recovery for you and your visitors.

## Key Features

-   **Proactive Protection**: Intercepts fatal errors (`E_ERROR`, `E_PARSE`, `E_COMPILE_ERROR`) before they can crash your entire site.
    
-   **Intelligent Recovery Mode**: Deactivates the culprit plugin or theme without manual intervention, allowing your site to stay online.
    
-   **Customizable User Experience**: Configure the plugin's behavior for visitors (e.g., maintenance page, redirect) and for administrators (e.g., toast notification, detailed error page).
    
-   **Comprehensive Logging**: Logs every intercepted error and action taken for easy diagnostics.
    
-   **Dry Run Mode**: Allows you to test the plugin without actually deactivating components, which is useful for debugging in development environments.
    
-   **Multilingual Support**: Ready for translation into any language.
    

## 🚀 Installation

Installing WP Crash Guard is an automated process. You don't need to do anything complex, as the installer file handles everything for you.

### Installation Steps

1.  Download the latest version of the plugin from GitHub.
    
2.  Log in to your WordPress dashboard.
    
3.  Go to **Plugins > Add New > Upload Plugin**.
    
4.  Select the downloaded `.zip` file and click **Install Now**.
    
5.  Once the installation is complete, click **Activate Plugin**.
    

**Please Note**: The plugin will automatically install itself as a "must-use" (`mu-plugin`). After activation, the installer file will self-delete, and you will be redirected to the plugin's settings page. You will no longer see the plugin in your regular plugin list, but it will be listed under **Plugins > Must-Use**.

## 🛠️ Detailed Configuration

After installation, you can customize WP Crash Guard's behavior from its settings page.

### Accessing Settings

1.  Log in to your WordPress dashboard.
    
2.  Navigate to **Crash Guard > Settings** in the left-hand menu.
    

### Detailed Explanation of Options

#### Behavior for Visitors

This option defines what visitors to your site will see if a critical error occurs. The goal is to minimize the impact on traffic and user experience.

-   **Do nothing**: The error is handled in the background. The problematic plugin is deactivated, and the page is reloaded silently. This is useful if you want the site to recover on its own without visitors noticing what happened.
    
-   **Automatically reload the page**: After handling the error, the site displays a simple "updating" screen and reloads automatically after a short delay. This alerts the user that something has happened but guides them to a successful recovery.
    
-   **Show maintenance page**: This replaces the error page with a professional maintenance page. This is the best choice for a production site, as it reassures visitors that the issue is temporary and is being addressed.
    
-   **Show custom message**: Similar to the maintenance page, but it allows you to insert a custom HTML message. This is ideal for displaying specific alerts or including contact information.
    
-   **Stealth mode**: The error is handled and the page reloads instantly. This is the most aggressive mode for recovery, showing no intermediate message to the user.
    

#### Behavior for Admins

This option controls how you are notified in case of an error, allowing you to choose the level of detail needed for debugging.

-   **Show full error details**: A blocking page (the white error screen) with all the technical details of the error (file, line, message). This is the most useful mode for developers but blocks site access until it is resolved.
    
-   **Show toast notification**: A small, unintrusive notification appears in the top right, informing you that a plugin has been deactivated. This allows you to continue working without interruptions but provides an immediate alert.
    
-   **Automatically reload**: The page reloads, and an alert informs you that a recovery has occurred. This is a good compromise between an immediate alert and a non-blocking experience.
    
-   **Show nothing**: The plugin acts completely silently. The only way to know that an error has been handled is to check the plugin's log page in the dashboard.
    

#### Error Interception Threshold

This option allows you to calibrate the sensitivity of WP Crash Guard, defining which error level should trigger a deactivation.

-   **Fatal Errors (E_ERROR)**: The plugin only intervenes for critical errors that would cause the site to crash. This is the safest and most recommended mode, as it will never deactivate a plugin for minor issues.
    
-   **Warnings & Above (E_WARNING)**: The plugin also intervenes for serious warnings. This is useful in development or staging environments to identify and resolve issues before they become fatal in production.
    
-   **Notices & Above (E_NOTICE)**: The plugin intervenes for almost all PHP issues, including non-critical notices. Use this option with caution, as it could lead to unintended deactivations for minor problems that do not affect the site's functionality.
    

## 🔍 Diagnostics & Logging

WP Crash Guard logs every action and error to help you with troubleshooting.

### Viewing Recent Errors

1.  Go to **Crash Guard > WP Crash Guard** in your dashboard.
    
2.  The first tab, **Recent Errors**, displays a list of intercepted errors, including details on the plugin, the type of error, the date, and the user involved.
    

### Viewing the Action Log

1.  On the same page, click the **Action Log** tab.
    
2.  Here you will find a list of all plugin actions, such as plugin activation or automatic deactivation, along with the date and user.
    

### Clearing Logs

On both tabs, you will find a **Clear** button to empty the logs and keep your database clean.

## 💡 Common Troubleshooting

-   **White page after installation**: If your site displays a white page after activation, don't worry. The installer has completed its process and the plugin is already active. Simply reload the page and navigate to your dashboard.
    
-   **WP Crash Guard is not in the plugin list**: This is the correct behavior. As a `mu-plugin`, it loads before all other plugins. To see it, go to **Plugins > Must-Use**.
    
-   **A plugin was unexpectedly deactivated**: Check the **Recent Errors** section to find the cause. The plugin will show you the exact file and line of code that generated the problem.
