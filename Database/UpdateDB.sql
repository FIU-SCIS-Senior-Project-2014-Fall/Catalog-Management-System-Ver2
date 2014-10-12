-- Please run this script before you do any changes to the script
-- Add changes for the database here so that no importing or exporting of database is needed.

/*Jose changes  10/7/2014--
Changes to the acl_users table now superuser field with the following codes:
superadmin = 1;
admin = 2;
advisor = 3;
student = 4;
guest = 0; ( unset value );

*/
update acl_users
set superuser = 2
where username = 'admin';

update acl_users
set superuser = 3
where username = 'oscara';

update acl_users 
set superuser = 4
where username = 'demo'

/*Jose Changes 10/11/2014
changes to catalog table so that now it can tell where a catalog is prospective or not, and who was the creator
*/
ALTER TABLE `curriculum`.`catalog` 
ADD COLUMN `isProspective` INT(1) NULL AFTER `description`,
ADD COLUMN `creatorId` VARCHAR(45) NULL AFTER `isProspective`;