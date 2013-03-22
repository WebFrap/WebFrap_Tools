<?php 

$console->out( I18n::get('Aufräumen der Installationsdateien') );

if ( $console->question
(
  "Das Setup war erfolgreich.\n"
    ."Die temporären Installationsdaten werden nun nichtmehr benötigt.\n"
    ."Es wird empfohlen diese Daten zu löschen.\n"
    ."Sollen die Daten jetzt gelöscht werden?"
))
{

  if ( Fs::exists( './code' ) )
    Fs::del( './code' );
  
}