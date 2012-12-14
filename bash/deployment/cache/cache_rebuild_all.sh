#!/bin/bash
# rebuild the complete cache

writeLn "Rebuild the CSS / JS and Theme cache"

# jump in the gateway
cd "${deplPath}/${gatewayName}"

/usr/bin/php ./cli.php Webfrap.cache.rebuildAllCss
/usr/bin/php ./cli.php Webfrap.cache.rebuildAllJs
/usr/bin/php ./cli.php Webfrap.cache.rebuildAllAppTheme
/usr/bin/php ./cli.php Webfrap.cache.rebuildAllWebTheme

# jump back to the package path
cd $packagePath


