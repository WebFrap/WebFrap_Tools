<?php

$conf->appName = $console->readText
(
  'Bitte einen Namen für die Installation angeben',
  'Name der Applikation',
  isset($conf->deployRoot)?:'',
  true
);

$conf->appDomain = $console->readText
(
  "Bitte eine Domain für die Applikation angeben.\nZ.B. \"my.domain.de\" ",
  'Domain der Applikation',
  isset($conf->appDomain)?:'',
  true
);
