# V8N - Validation
## Overview
The cc.php script provides a simple validation check based on cookies and a server-side protec ted whitelist.
## Usage
### Install
1. Copy the `cc.php` script into a folder (e.g. 'v8n').
1. (Optional for better security) Add Directory directives in apache server conf to secure the folder from distribution by the server, thus -
      ``` conf
      <Directory v8n>
          Order deny,allow
          Deny from all
      </Directory>
      ```
1. include the php at the head of the index script.
2. call the validation function and allow or deny access based on the boolean result.
### Startup
The script requires no explicit administration except being `open` or `closed`, and this can be manipulated by directly editing the file `status.txt` in the v8n folder to have the one word either `open` or `close` to represent the desired status.
### Open Status
when `open`, then any new visitor will receive a cookie which will be added to the whitelist. That cookie represents their entry token and grants access even when the site is in 'closed' status.
### Closed Status
When `closed`, the script will return false for all visitors *except* those with either `access` or `admin` whitelisted cookies.
### Operational Components
1. The `cc.php` script contains the `cc_validation` function which performs the calls and checks to maintain functionality.
1. The `status.txt` file is created and updated when needed to record the current accessibility status of the system.
1. The `access.txt` file is added to as visitors are granted access while the site is `open`, and merely referred to while `closed`.
1. The `admin.txt` is never updated by the script, but can be added to or deleted from to control access to the admin functions.
### Admin Functions
Add an entry in the `admin.txt` file and create a cookie of the same name and value in a browser. That browser can then access the admin functionality. Admin functions are reqstricted to keywords in the url parameters as follows.
1. `open` - this switches the site to `open` status.
1. `close` - this switches the site to `close` status.
### Features
1. Removing an entry from one of the whitelists will deny access on the next page load.
1. Denial of access will lead to clearing of all cookies by expiry.
