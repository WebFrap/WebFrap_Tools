<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
* 
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

// die Basis Logik einbinden
// hier wird auch das entsprechende conf / settingsfile eingebunden
// in welchem die hier verwendetetn Variablen vorhanden sind.
include 'gaia/core.php';

#
# CA - wrapper around ca to make it easier to use ... basically ca requires
#      some setup stuff to be done before you can use it and this makes
#      things easier between now and when Eric is convinced to fix it :-)
#
# CA -newca ... will setup the right stuff
# CA -newreq[-nodes] ... will generate a certificate request 
# CA -sign ... will sign the generated request and output 

if( Request::arg('help') )
{
  Console::outl( "usage: ssl_cert.php \"help\" # for help" );
  Console::outl( "usage: ssl_cert.php \"do=newcert|newreq|newreq-nodes|newca|sign|verify\"" );
  Console::outl( "usage: ssl_cert.php \"cert=/cert/file&key=/cert/key.file&do=newcert|newreq|newca|sign|verify\"" );
  exit(0);
}

$SSLEAY_CONFIG=$ENV{"SSLEAY_CONFIG"};
$DAYS="-days 365";  # 1 year
$CADAYS="-days 1095";  # 3 years
$REQ="$openssl req $SSLEAY_CONFIG";
$CA="$openssl ca $SSLEAY_CONFIG";
$VERIFY="$openssl verify";
$X509="$openssl x509";
$PKCS12="$openssl pkcs12";

$CATOP="./demoCA";
$CAKEY="cakey.pem";
$CAREQ="careq.pem";
$CACERT="cacert.pem";

$DIRMODE = 0777;

$RET = 0;

foreach (@ARGV) {
  if ( /^(-\?|-h|-help)$/ ) {
      print STDERR "usage: CA -newcert|-newreq|-newreq-nodes|-newca|-sign|-verify\n";
      print STDERR "usage: CA -signcert certfile keyfile|-newcert|-newreq|-newca|-sign|-verify\n";
      exit 0;
  } elsif (/^-newcert$/) {
      # create a certificate
      system ("$REQ -new -x509 -keyout newkey.pem -out newcert.pem $DAYS");
      $RET=$?;
      print "Certificate is in newcert.pem, private key is in newkey.pem\n"
  } elsif (/^-newreq$/) {
      # create a certificate request
      system ("$REQ -new -keyout newkey.pem -out newreq.pem $DAYS");
      $RET=$?;
      print "Request is in newreq.pem, private key is in newkey.pem\n";
  } elsif (/^-newreq-nodes$/) {
      # create a certificate request
      system ("$REQ -new -nodes -keyout newkey.pem -out newreq.pem $DAYS");
      $RET=$?;
      print "Request is in newreq.pem, private key is in newkey.pem\n";
  } elsif (/^-newca$/) {
    # if explicitly asked for or it doesn't exist then setup the
    # directory structure that Eric likes to manage things 
      $NEW="1";
      if ( "$NEW" || ! -f "${CATOP}/serial" ) {
    # create the directory hierarchy
    mkdir $CATOP, $DIRMODE;
    mkdir "${CATOP}/certs", $DIRMODE;
    mkdir "${CATOP}/crl", $DIRMODE ;
    mkdir "${CATOP}/newcerts", $DIRMODE;
    mkdir "${CATOP}/private", $DIRMODE;
    open OUT, ">${CATOP}/index.txt";
    close OUT;
    open OUT, ">${CATOP}/crlnumber";
    print OUT "01\n";
    close OUT;
      }
      if ( ! -f "${CATOP}/private/cakey.pem" ) {
    print "CA certificate filename (or enter to create)\n";
    $FILE = <STDIN>;

    chop $FILE;

    # ask user for existing CA certificate
    if ($FILE) {
        cp_pem($FILE,"${CATOP}/private/cakey.pem", "PRIVATE");
        cp_pem($FILE,"${CATOP}/cacert.pem", "CERTIFICATE");
        $RET=$?;
    } 
    else 
    {
        print "Making CA certificate ...\n";
        system ("$REQ -new -keyout " .
      "${CATOP}/private/cakey.pem -out ${CATOP}/careq.pem");
        
        system ("$CA -create_serial " .
      "-out ${CATOP}/cacert.pem $CADAYS -batch " . 
      "-keyfile ${CATOP}/private/cakey.pem -selfsign " .
      "-extensions v3_ca " .
      "-infiles ${CATOP}/careq.pem ");
        $RET=$?;
    }
   }
  } 
  elsif (/^-pkcs12$/) {
      my $cname = $ARGV[1];
      $cname = "My Certificate" unless defined $cname;
      system ("$PKCS12 -in newcert.pem -inkey newkey.pem " .
      "-certfile ${CATOP}/cacert.pem -out newcert.p12 " .
      "-export -name \"$cname\"");
      $RET=$?;
      print "PKCS #12 file is in newcert.p12\n";
      exit $RET;
  } elsif (/^-xsign$/) {
      system ("$CA -policy policy_anything -infiles newreq.pem");
      $RET=$?;
  } elsif (/^(-sign|-signreq)$/) {
      system ("$CA -policy policy_anything -out newcert.pem " .
              "-infiles newreq.pem");
      $RET=$?;
      print "Signed certificate is in newcert.pem\n";
  } elsif (/^(-signCA)$/) {
      system ("$CA -policy policy_anything -out newcert.pem " .
          "-extensions v3_ca -infiles newreq.pem");
      $RET=$?;
      print "Signed CA certificate is in newcert.pem\n";
  } elsif (/^-signcert$/) {
      system ("$X509 -x509toreq -in newreq.pem -signkey newreq.pem " .
                "-out tmp.pem");
      system ("$CA -policy policy_anything -out newcert.pem " .
              "-infiles tmp.pem");
      $RET = $?;
      print "Signed certificate is in newcert.pem\n";
  } elsif (/^-verify$/) {
      if (shift) {
    foreach $j (@ARGV) {
        system ("$VERIFY -CAfile $CATOP/cacert.pem $j");
        $RET=$? if ($? != 0);
    }
    exit $RET;
      } else {
        system ("$VERIFY -CAfile $CATOP/cacert.pem newcert.pem");
        $RET=$?;
            exit 0;
      }
  } else {
      print STDERR "Unknown arg $_\n";
      print STDERR "usage: CA -newcert|-newreq|-newreq-nodes|-newca|-sign|-verify\n";
      print STDERR "usage: CA -signcert certfile keyfile|-newcert|-newreq|-newca|-sign|-verify\n";
      exit 1;
  }
}

exit $RET;

sub cp_pem {
  my ($infile, $outfile, $bound) = @_;
  open IN, $infile;
  open OUT, ">$outfile";
  my $flag = 0;
  while (<IN>) {
    $flag = 1 if (/^-----BEGIN.*$bound/) ;
    print OUT $_ if ($flag);
    if (/^-----END.*$bound/) {
      close IN;
      close OUT;
      return;
    }
  }
}







