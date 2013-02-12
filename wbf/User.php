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

///
/// NEIN, DIES DATEI ERHEBT NICHT DEN ANSPRUCH OOP ZU SEIN.
/// ES IS EXPLIZIT AUCH NICHT ALS OOP GEWOLLT.
/// DIE KLASSEN WERDEN LEDIGLICH ALS CONTAINER ZUM ORGANISIEREN DER FUNKTIONEN VERWENDET.
/// JA DAS IST VIEL CODE FÜR EINE DATEI, NEIN ES IST KEIN PROBLEM
/// NEIN ES IST WIRKLICH KEIN PROBLEM, SOLLTE ES DOCH ZU EINEM WERDEN WIRD ES
/// GELÖST SOBALD ES EINS IST
/// Danke ;-)
///

/**
 * Klasse für das Management eines Mercurial Repository
 * @package WebFrap
 * @subpackage Gaia
 */
class User
{

  /**
   * @param string $file Link zum File
   * @param array $types Position und Type des Items
   * @param array $dbs Liste den mit Datenbanken
   * @param string $key mit key kann eine bestimmte Datenbank Verbindun spezifiziert werden
   */
  public static function importContactItems( $file, $types, $dbs, $key = null )
  {

    $data = File::getCsvContent( $file, 1 );

    foreach ($data as $row) {
      foreach ($dbs['db'] as $dbKey => $dbData) {

        if( !is_null($key) && $dbKey !== $key  )
          continue;

        foreach ($types as $pos => $itemType) {

          // keine leeren items importieren
          if( '' == trim($row[$pos]) )
            continue;

          $uuid         = Gaia::uuid();
          $timeCreated  = Gaia::timestamp();

          $sql = <<<SQL
INSERT INTO {$dbData['schema']}.wbfsys_address_item
(
  id_user,
  address_value,
  id_type,
  use_for_contact,
  m_uuid,
  m_time_created,
  m_role_create,
  m_version
)
VALUES
(
  {$row[0]},
  '{$row[$pos]}',
  (
    select
      rowid
    from
      {$dbData['schema']}.wbfsys_address_item_type
    where
      upper(access_key) = upper( '{$itemType}' )
  ),
  TRUE,
  '{$uuid}',
  '{$timeCreated}',
  (
    select
      rowid
    from
      {$dbData['schema']}.wbfsys_role_user
    where
      upper(name) = upper( 'system' )
  ),
  0
);
SQL;
          echo Db::query
          (
            $sql,
            $dbData['name'],
            $dbs['root_user'],
            $dbs['root_pwd']
          );

        }
      }
    }

  }//end public static function importContactItems */

  /**
   * @param UserContainer $userContainer
   * @param array $dbs
   * @param string $key
   */
  public static function addUser( $userContainer, $dbs, $key = null  )
  {

    foreach ($dbs['db'] as $dbKey => $dbData) {

      if( !is_null($key) && $dbKey !== $key  )
        continue;

      $timeCreated  = Gaia::timestamp();

// person
      $personUuid   = Gaia::uuid();

      $sql = <<<SQL
INSERT INTO {$dbData['schema']}.core_person
(
  firstname,
  lastname,
  m_uuid,
  m_time_created,
  m_role_create,
  m_version
)
VALUES
(
  '{$userContainer->firstname}',
  '{$userContainer->lastname}',
  '{$personUuid}',
  '{$timeCreated}',
  (
    select
      rowid
    from
      {$dbData['schema']}.wbfsys_role_user
    where
      upper(name) = upper( 'system' )
  ),
  0
);
SQL;
      echo Db::query
      (
        $sql,
        $dbData['name'],
        $dbs['root_user'],
        $dbs['root_pwd']
      );

// user

    $roleUuid   = Gaia::uuid();

    $sql = <<<SQL
INSERT INTO {$dbData['schema']}.wbfsys_role_user
(
  name,
  id_person,
  level,
  profile,
  m_uuid,
  m_time_created,
  m_role_create,
  m_version
)
VALUES
(
  '{$userContainer->name}',
  (
    select
      rowid
    from
      {$dbData['schema']}.core_person
    where
      m_uuid = '{$personUuid}'
  ),
  '{$userContainer->level}',
  '{$userContainer->profile}',
  '{$roleUuid}',
  '{$timeCreated}',
  (
    select
      rowid
    from
      {$dbData['schema']}.wbfsys_role_user
    where
      upper(name) = upper( 'system' )
  ),
  0
);
SQL;
      echo Db::query
      (
        $sql,
        $dbData['name'],
        $dbs['root_user'],
        $dbs['root_pwd']
      );

      if ( '' != trim($userContainer->email) ) {

        $uuidMail         = Gaia::uuid();

        $sql = <<<SQL
INSERT INTO {$dbData['schema']}.wbfsys_address_item
(
  id_user,
  address_value,
  id_type,
  use_for_contact,
  m_uuid,
  m_time_created,
  m_role_create,
  m_version
)
VALUES
(
  (
    select
      rowid
    from
      {$dbData['schema']}.wbfsys_role_user
    where
      m_uuid = '{$roleUuid}'
  ),
  '{$userContainer->email}',
  (
    select
      rowid
    from
      {$dbData['schema']}.wbfsys_address_item_type
    where
      upper(access_key) = upper( 'mail' )
  ),
  TRUE,
  '{$uuidMail}',
  '{$timeCreated}',
  (
    select
      rowid
    from
      {$dbData['schema']}.wbfsys_role_user
    where
      upper(name) = upper( 'system' )
  ),
  0
);
SQL;
        echo Db::query
        (
          $sql,
          $dbData['name'],
          $dbs['root_user'],
          $dbs['root_pwd']
        );
      }

      $uuidMessage  = Gaia::uuid();

      $sql = <<<SQL
INSERT INTO {$dbData['schema']}.wbfsys_address_item
(
  id_user,
  address_value,
  id_type,
  use_for_contact,
  m_uuid,
  m_time_created,
  m_role_create,
  m_version
)
VALUES
(
  (
    select
      rowid
    from
      {$dbData['schema']}.wbfsys_role_user
    where
      m_uuid = '{$roleUuid}'
  ),
  (
    select
      rowid
    from
      {$dbData['schema']}.wbfsys_role_user
    where
      m_uuid = '{$roleUuid}'
  ),
  (
    select
      rowid
    from
      {$dbData['schema']}.wbfsys_address_item_type
    where
      upper(access_key) = upper( 'message' )
  ),
  TRUE,
  '{$uuidMail}',
  '{$timeCreated}',
  (
    select
      rowid
    from
      {$dbData['schema']}.wbfsys_role_user
    where
      upper(name) = upper( 'system' )
  ),
  0
);
SQL;
      echo Db::query
      (
        $sql,
        $dbData['name'],
        $dbs['root_user'],
        $dbs['root_pwd']
      );

    }//end foreach

  }//end public static function addUser */

}//end class User */