-- Legacy rows use both CORRESPONDENCE and CORRESPONDENCEADDRESS.
-- New addresses are always CORRESPONDENCEADDRESS, which is the translated key.
USE `onlinfi7_officekaterina`;

UPDATE `owneraddress`
SET `addressType` = 'CORRESPONDENCEADDRESS'
WHERE `addressType` = 'CORRESPONDENCE';
