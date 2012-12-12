#!/bin/bash
# rebuild the complete cache

# jump in the gateway
cd "${deplPath}/${gatewayName}"

writeLn "Rebuild the CSS / JS and Theme cache"

/usr/bin/php ./cli.php Webfrap.cache.rebuildAllCss
/usr/bin/php ./cli.php Webfrap.cache.rebuildAllJs
/usr/bin/php ./cli.php Webfrap.cache.rebuildAllTheme

# jump back to the package path
cd $packagePath


