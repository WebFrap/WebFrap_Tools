#!/bin/bash


#rm -rf /var/www/WorkspaceWebFrap/SDB_App_SBiz/{module,conf,data,i18n,templates}

wspPath="/var/www/WorkspaceWebFrap/"

cartridges="Profile,Desktop,DesktopTemplate,DesktopIndexSimple,DesktopNavigation,DesktopNavigationTree,DesktopPanel,DesktopMainmenu"
metadata="MetadataModule,MetadataModuleAccess,MetadataEntity,MetadataEntityAccess,MetadataDbSyncPostgresql,MetadataManagement,MetadataManagementAccess,MetadataProfile,MetadataProcess"
pages="PageController,PageModel,PageTemplates,PageView,PageMasterTemplates"
multi="MultiController,MultiModel"
module="Module,ModuleI18n,ModuleController,ModuleSubwindow,ModuleSubwindowMenu,ModuleMaintab,ModuleMaintabMenu"
widget="Widget"
process="Process"
item="Item"
tests="TestDbms,TestEntity"
doku="DokuErd"

cd "${wspPath}SDB_Gw_SBiz"

php ./cli.php Daidalos.Projects.clean "pfile=${wspPath}SDB_42_SBiz/projects/sbiz/Project.bdl"
#php ./cli.php Daidalos.Projects.build "pfile=/var/www/WorkspaceWebFrap/SDB_42_SBiz/projects/sbiz/Project.bdl" #"catridges=${tests}"  #| tee ../protocol_build_sbiz.log #"catridges=${widget}" 
php ./cli.php Daidalos.Projects.build "pfile=${wspPath}SDB_42_SBiz/projects/sbiz/Project.bdl" "cartridges=${1}"
php ./cli.php Daidalos.Projects.deploy "pfile=${wspPath}SDB_42_SBiz/projects/sbiz/Project.bdl"



