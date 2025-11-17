# CanDO Nursery - Server Setup Instructions

## Overview
The admin configuration panel now saves directly to `config.json` on your server, so all investors see updated numbers immediately without any action on their part.

## Files to Upload

Upload these files to your server at `https://strategygate.org/cando/`:

1. `cando_business_investors.html` - Main investor presentation
2. `cando_prospectus_complete.html` - Complete prospectus
3. `cando_admin_config.html` - Admin configuration panel (for you only)
4. `config.json` - Configuration data file
5. `save_config.php` - Backend script to save configurations
6. `test_dynamic_text.html` - Test file (optional)

## Important: File Permissions

For the system to work properly, you MUST set the correct file permissions on your server:

### Required Permissions:

1. **config.json** - Must be writable by the web server
   ```bash
   chmod 666 config.json
   ```
   Or via FTP/cPanel: Set permissions to `666` (read/write for everyone)

2. **save_config.php** - Must be executable
   ```bash
   chmod 644 save_config.php
   ```
   Or via FTP/cPanel: Set permissions to `644` (standard PHP file)

3. **Parent directory** (optional, if above doesn't work)
   ```bash
   chmod 777 /path/to/cando/
   ```
   Or via FTP/cPanel: Set directory permissions to `777` (full access)

### Setting Permissions via cPanel:

1. Log into your cPanel
2. Open "File Manager"
3. Navigate to `/public_html/cando/` (or wherever your files are)
4. Right-click on `config.json` → Select "Change Permissions"
5. Check: Read + Write for Owner, Group, and World (or enter `666`)
6. Click "Change Permissions"

### Setting Permissions via FTP (FileZilla, etc.):

1. Connect to your server via FTP
2. Navigate to the `cando` folder
3. Right-click on `config.json` → Select "File Permissions"
4. Enter `666` in the numeric value field
5. Click OK

## Testing the Setup

### Step 1: Test PHP Backend
Visit: `https://strategygate.org/cando/save_config.php`

You should see:
- Either a blank page (good)
- Or a JSON error about "Method not allowed" (good - means PHP is working)

If you see a 404 or download prompt, PHP may not be properly configured on your server.

### Step 2: Test Admin Panel
1. Open: `https://strategygate.org/cando/cando_admin_config.html`
2. Change some values (e.g., student count)
3. Click "💾 Save to Server"
4. You should see: "✅ Configuration saved successfully to server!"

If you see "⚠️ Saved locally only", check:
- File permissions on `config.json` (must be writable)
- Browser console for error messages (F12 → Console tab)

### Step 3: Test Investor View
1. Open: `https://strategygate.org/cando/cando_business_investors.html`
2. Open browser console (F12 → Console tab)
3. Look for: "✅ Loaded configuration from server (config.json)"
4. Verify the numbers match what you set in the admin panel

## How to Update Numbers

### For You (Admin):

1. Open: `https://strategygate.org/cando/cando_admin_config.html`
2. Update any values you want to change
3. Click "💾 Save to Server"
4. Done! All investors will see the new numbers

### For Investors:

**They do nothing!** Just send them this link:
- `https://strategygate.org/cando/cando_business_investors.html`

They'll automatically see your latest numbers from `config.json`.

## Troubleshooting

### Problem: "Server save failed" message

**Solution:**
1. Check `config.json` file permissions (should be `666`)
2. Check that PHP is enabled on your server
3. Try uploading `save_config.php` again
4. Check server error logs (in cPanel: Errors → Error Log)

### Problem: Changes not showing for investors

**Solution:**
1. Verify the save was successful (green success message)
2. Ask investor to hard-refresh: Ctrl+F5 (Windows) or Cmd+Shift+R (Mac)
3. Check that `config.json` was actually updated on the server
4. Clear browser cache if needed

### Problem: PHP not working / file downloads instead of executing

**Solution:**
- Contact your hosting provider to enable PHP for the directory
- Ensure the file extension is `.php` not `.php.txt`
- Check that your hosting plan includes PHP support

### Problem: Permission denied when saving

**Solution:**
1. Set `config.json` permissions to `666`
2. If that doesn't work, set directory permissions to `777`
3. Check with hosting provider about file ownership

## Security Considerations

The current setup has **no authentication** on `save_config.php`. This means anyone who finds the URL could potentially update your configuration.

### To improve security (optional):

1. **Option 1: Password protect the admin panel**
   - Use cPanel "Password Protect Directories" feature
   - Protect the `/cando/` directory
   - Only give credentials to authorized users

2. **Option 2: Use .htaccess IP restriction**
   - Create a `.htaccess` file restricting access to your IP only
   - Only you can access the admin panel

3. **Option 3: Rename admin files**
   - Rename `cando_admin_config.html` to something hard to guess
   - Rename `save_config.php` to something hard to guess
   - Update the fetch URL in the HTML accordingly

## Backup

The system automatically creates `config.backup.json` every time you save. If something goes wrong, you can rename this file back to `config.json`.

## Support

If you encounter issues:
1. Check browser console (F12 → Console)
2. Check server error logs (cPanel → Error Log)
3. Verify all file permissions
4. Test that PHP is working on your server
5. Contact your hosting provider if PHP issues persist

---

**Summary:**
- Upload all files to your server
- Set `config.json` permissions to `666`
- Use `cando_admin_config.html` to update numbers
- Share `cando_business_investors.html` with investors
- Investors see updates automatically - no action needed from them!
