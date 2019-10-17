SELECT a.id AS id,
       a.id AS src_id,
       a.account_type_id AS src_account_type_id,
       t.name_th AS src_account_type,
       a.username AS src_username,
       a.status AS src_status,
       CONCAT(COALESCE(ap1.title_en,ap2.title_en), COALESCE(ap1.firstname_en,ap2.firstname_en), ' ' ,COALESCE(ap1.lastname_en,ap2.lastname_en)) AS src_name,
       COALESCE(ap1.birth_date,ap2.birth_date) AS src_birth_date,
       COALESCE(ap1.nationality_id,ap2.nationality_id) AS src_nationality_id,
       a.created AS src_created,
       c.id AS des_id,
       c.name AS des_name,
       c.account_type_id AS des_account_type_id,
       c.account_type AS des_account_type,
       c.username AS des_username,
       c.status AS des_status,
       c.birth_date AS des_birth_date,
       c.nationality_id AS des_nationality_id,
       c.created AS des_created
FROM account a
INNER JOIN account_type t ON t.id = a.account_type_id
LEFT JOIN account_profile_general_foreigner ap1 ON ap1.account_id = a.id
LEFT JOIN account_profile_diplomat_foreigner ap2 ON ap2.account_id = a.id
LEFT JOIN
  (SELECT b.id,
          b.account_type_id,
          bt.name_th AS account_type,
          b.username,
          b.status,
          b.created,
          CONCAT(COALESCE(bp1.title_en,bp2.title_en), COALESCE(bp1.firstname_en,bp2.firstname_en), ' ' ,COALESCE(bp1.lastname_en,bp2.lastname_en)) AS name,
          COALESCE(bp1.birth_date,bp2.birth_date) AS birth_date,
          COALESCE(bp1.nationality_id,bp2.nationality_id) AS nationality_id
   FROM account b
   INNER JOIN account_type bt ON bt.id = b.account_type_id
   LEFT JOIN account_profile_general_foreigner bp1 ON bp1.account_id = b.id
   LEFT JOIN account_profile_diplomat_foreigner bp2 ON bp2.account_id = b.id) c ON c.id <> a.id
AND COALESCE(ap1.birth_date,ap2.birth_date) = c.birth_date
AND COALESCE(ap1.nationality_id,ap2.nationality_id) = c.nationality_id
AND c.status <> -1
WHERE t.is_foreigner = 1
  AND a.status = 0
  AND c.status <> 0
  AND c.id IS NOT NULL
