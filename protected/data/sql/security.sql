UPDATE account
SET 
legacy_secret = secret,
is_legacy = 1;
UPDATE user
SET 
legacy_secret = secret,
is_legacy = 1;
