# Piwik AdminNotification Plugin
## Description
Adds the ability for Piwik administrators to include an informative message on all users' dashboards. This may be useful for communicating with users in larger shared environments. In our setup we were tracking 1,900 websites with 250 users. This is a solution we wrote to allow us to easily inform our users of maintenance windows.

## Instructions
The easiest way to install is to find the plugin in the [Piwik Marketplace](http://plugins.piwik.org/).

## Changelog
* 3.0.0 Piwik v3 compatible. Effort was made to maintain backwards compatibility. This should work all the way back to 2.12.x
* 0.1.2 Tested with Piwik v2.15 and included new registerEvents() hook for compatibility with Piwik 3.0
* 0.1.1 Cleanup. Removed plugin template verbiage from code files.
* 0.1.0 Initial Release

## Known Issues
* v3.0.0 Display/Update of notification requires logout/login to see change. (Notification API not working as expected during tests)

##License
GPL v3 / fair use

## Support
Please [report any issues](https://github.com/jbrule/piwikplugin-AdminNotification/issues). Pull requests welcome.
