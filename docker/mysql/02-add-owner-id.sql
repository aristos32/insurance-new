-- Give owner a numeric PK for routing. Production stateIds often contain a
-- slash (e.g. 5/28288), which splits /owners/{stateId} into two segments.
-- stateId stays UNIQUE so existing foreign keys are unchanged.
USE `onlinfi7_officekaterina`;

ALTER TABLE `owner`
  ADD COLUMN `id` int(10) NOT NULL AUTO_INCREMENT FIRST,
  ADD PRIMARY KEY (`id`);
