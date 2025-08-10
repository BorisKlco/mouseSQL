Regularly audit permissions:
SELECT * FROM information_schema.role_table_grants WHERE grantee = 'username';

-- As admin, check what they can access:
SELECT * FROM information_schema.schemata WHERE schema_owner = 'username';
SELECT * FROM information_schema.table_privileges WHERE grantee = 'username';

Check Size of a User's Schema + All Objects Inside
SELECT 
    nspname AS schema_name,
    pg_size_pretty(SUM(pg_total_relation_size(quote_ident(nspname) || '.' || quote_ident(relname)))) AS total_size
FROM 
    pg_class c
JOIN 
    pg_namespace n ON (c.relnamespace = n.oid)
WHERE 
    nspname = 'user_schema_name'
GROUP BY 
    nspname;


Check Size of a Specific User's Schema
SELECT 
    schema_name,
    pg_size_pretty(pg_total_relation_size(schema_name || '.table_name')) AS table_size
FROM 
    information_schema.schemata
WHERE 
    schema_name = 'user_schema_name';



Check Size of a Specific User's OWNED Objects (Across All Schemas)
SELECT 
    nspname AS schema_name,
    pg_size_pretty(SUM(pg_total_relation_size(nspname || '.' || relname))) AS total_size
FROM 
    pg_class c
JOIN 
    pg_namespace n ON (c.relnamespace = n.oid)
JOIN 
    pg_user u ON (c.relowner = u.usesysid)
WHERE 
    u.usename = 'username'
GROUP BY 
    nspname;


Check Size of ALL Schemas (Including User Schemas)
SELECT 
    schema_name,
    pg_size_pretty(SUM(pg_total_relation_size(quote_ident(schemaname) || '.' || quote_ident(tablename)))) AS total_size
FROM 
    pg_tables
WHERE 
    schemaname NOT LIKE 'pg_%' AND schemaname != 'information_schema'
GROUP BY 
    schema_name
ORDER BY 
    SUM(pg_total_relation_size(quote_ident(schemaname) || '.' || quote_ident(tablename)) DESC;


