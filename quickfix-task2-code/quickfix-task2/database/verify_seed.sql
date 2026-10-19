-- ===========================================================================
-- Row counts per table. The CI job asserts that none of these is below ten,
-- which is the Task 2 requirement for populating the database.
--   mysql -N -B quickfix_db < database/verify_seed.sql
-- ===========================================================================
SELECT 'admin'                  AS table_name, COUNT(*) AS rows_loaded FROM admin
UNION ALL SELECT 'app_user',               COUNT(*) FROM app_user
UNION ALL SELECT 'repair_pricing',         COUNT(*) FROM repair_pricing
UNION ALL SELECT 'repair_booking',         COUNT(*) FROM repair_booking
UNION ALL SELECT 'booking_status_history', COUNT(*) FROM booking_status_history
UNION ALL SELECT 'trade_in_request',       COUNT(*) FROM trade_in_request
UNION ALL SELECT 'purchase_enquiry',       COUNT(*) FROM purchase_enquiry
UNION ALL SELECT 'notification_log',       COUNT(*) FROM notification_log;
