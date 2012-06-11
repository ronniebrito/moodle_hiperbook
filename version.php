<?PHP // $Id: version.php,v 1.11 2005/07/14 20:58:07 skodak Exp $

/////////////////////////////////////////////////////////////////////////////////
///  Called by moodle_needs_upgrading() and /admin/index.php
/////////////////////////////////////////////////////////////////////////////////

$module->version  = 2011121002;  // The current module version (Date: YYYYMMDDXX)
$module->requires = 2005060210;  // Requires this Moodle version
$module->cron     = 0;           // Period for cron to check this module (secs)

$release = "1.2RC";                // User-friendly version number

?>
