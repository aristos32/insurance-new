-- Merge global auth columns/rows into onlinfi7_officekaterina.systemuser,
-- then drop the global database. This office is cyprus-insurances.
USE `onlinfi7_officekaterina`;

ALTER TABLE `systemuser`
  ADD COLUMN `password` varchar(60) NOT NULL DEFAULT '' AFTER `username`,
  ADD COLUMN `role` varchar(5) DEFAULT NULL AFTER `password`,
  ADD COLUMN `status` varchar(20) NOT NULL DEFAULT 'ACTIVE' AFTER `role`,
  ADD COLUMN `clientName` varchar(40) NOT NULL DEFAULT 'cyprus-insurances' AFTER `status`,
  ADD COLUMN `productType` varchar(20) DEFAULT NULL AFTER `clientName`,
  ADD COLUMN `consecutiveFailLoginAttempts` int(3) DEFAULT NULL AFTER `productType`;

UPDATE `systemuser` AS o
INNER JOIN `onlinfi7_globalonlineinsa`.`systemuser` AS g
  ON g.username = o.username AND g.clientName = 'cyprus-insurances'
SET
  o.password = g.password,
  o.role = g.role,
  o.status = g.status,
  o.clientName = g.clientName,
  o.productType = g.productType,
  o.consecutiveFailLoginAttempts = g.consecutiveFailLoginAttempts;

INSERT INTO `systemuser` (
  `username`,
  `password`,
  `role`,
  `status`,
  `clientName`,
  `productType`,
  `consecutiveFailLoginAttempts`,
  `email`
)
SELECT
  g.username,
  g.password,
  g.role,
  g.status,
  g.clientName,
  g.productType,
  g.consecutiveFailLoginAttempts,
  CONCAT(g.username, '@office.local')
FROM `onlinfi7_globalonlineinsa`.`systemuser` AS g
LEFT JOIN `systemuser` AS o ON o.username = g.username
WHERE g.clientName = 'cyprus-insurances'
  AND o.username IS NULL;

DROP DATABASE IF EXISTS `onlinfi7_globalonlineinsa`;

GRANT ALL PRIVILEGES ON `onlinfi7_officekaterina`.* TO 'insurance'@'%';
FLUSH PRIVILEGES;
