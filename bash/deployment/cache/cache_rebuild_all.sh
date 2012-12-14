#!/bin/bash
# rebuild the complete cache

writeLn "Rebuild the CSS / JS and Theme cache"

# jump in the gateway
cd "${deplPath}/${gatewayName}"

/usr/bin/php ./cli.php Webfrap.cache.rebuildAllCss
chown -R "$codeOwner" "${deplPath}/${gatewayName}/cache/css"

/usr/bin/php ./cli.php Webfrap.cache.rebuildAllJs
chown -R "$codeOwner" "${deplPath}/${gatewayName}/cache/javascript"

/usr/bin/php ./cli.php Webfrap.cache.rebuildAllAppTheme
chown -R "$codeOwner" "${deplPath}/${gatewayName}/cache/app_theme"

/usr/bin/php ./cli.php Webfrap.cache.rebuildAllWebTheme
chown -R "$codeOwner" "${deplPath}/${gatewayName}/cache/web_theme"

# jump back to the package path
cd $packagePath


