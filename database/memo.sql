SELECT 
`reports`.`id` AS 'id' ,
`reports`.`date` AS 'date' ,
date_format(`reports`.`date` , '%Y/%m/%d') AS 'formated_date',
`users`.`name` AS 'user_name' ,
`reports`.`project_id` AS 'project_id', 
`projects`.`project_name` AS 'project_name', 
`projects`.`clients_name` AS 'clients_name', 
`reports`.`working_time` AS 'working_time', 
time_format(`reports`.`working_time` , '%H:%i') AS 'formated_working_time',
`operations`.`name` AS 'operations_name',
`reports`.`url` AS 'url'
FROM `reports`
INNER JOIN (SELECT `projects`.`id` AS 'project_id' , `projects`.`name` AS 'project_name' , `clients`.`name` AS 'clients_name' FROM `projects` INNER JOIN `clients` ON `projects`.`client_id` = `clients`.`id`) AS `projects`
ON `reports`.`project_id` = `projects`.`project_id`
INNER JOIN `users`
ON `reports`.`user_id` = `users`.`id`
INNER JOIN `operations`
ON `reports`.`operation_id` = `operations`.`id`;