-- ===========================================================================
-- QuickFix Laptop Solutions - seed data
-- Simulated but realistic records. Every table holds at least ten rows, as
-- required by the Task 2 brief. Run after schema.sql.
--   mysql -u root -p quickfix_db < database/seed_data.sql
-- ===========================================================================

SET NAMES utf8mb4;

-- ---------------------------------------------------------------------------
-- admin (10 rows). Hashes are bcrypt of 'QuickFix2026!' - development only.
-- ---------------------------------------------------------------------------
INSERT INTO admin (full_name, email, password_hash, role, last_login) VALUES
('Sibusiso Brian Sindane','sibusiso@quickfix.co.za','$2y$10$M0eXl7cSVjQ0Yk3u6hTg3uH5ZJ0t1pQy6o1eVZ0bqD4kE1rTtQe9C','superadmin','2026-10-18 08:12:00'),
('Lesego Mogara','lesego@quickfix.co.za','$2y$10$M0eXl7cSVjQ0Yk3u6hTg3uH5ZJ0t1pQy6o1eVZ0bqD4kE1rTtQe9C','admin','2026-10-17 16:40:00'),
('Muvhuso Ndanduleni','muvhuso@quickfix.co.za','$2y$10$M0eXl7cSVjQ0Yk3u6hTg3uH5ZJ0t1pQy6o1eVZ0bqD4kE1rTtQe9C','admin','2026-10-18 09:02:00'),
('Thabiso Dlamini','thabiso@quickfix.co.za','$2y$10$M0eXl7cSVjQ0Yk3u6hTg3uH5ZJ0t1pQy6o1eVZ0bqD4kE1rTtQe9C','admin','2026-10-16 11:25:00'),
('Nandi Khumalo','nandi@quickfix.co.za','$2y$10$M0eXl7cSVjQ0Yk3u6hTg3uH5ZJ0t1pQy6o1eVZ0bqD4kE1rTtQe9C','technician','2026-10-18 07:55:00'),
('Pieter van Wyk','pieter@quickfix.co.za','$2y$10$M0eXl7cSVjQ0Yk3u6hTg3uH5ZJ0t1pQy6o1eVZ0bqD4kE1rTtQe9C','technician','2026-10-15 14:10:00'),
('Aisha Patel','aisha@quickfix.co.za','$2y$10$M0eXl7cSVjQ0Yk3u6hTg3uH5ZJ0t1pQy6o1eVZ0bqD4kE1rTtQe9C','technician','2026-10-17 10:05:00'),
('Tumelo Mokoena','tumelo@quickfix.co.za','$2y$10$M0eXl7cSVjQ0Yk3u6hTg3uH5ZJ0t1pQy6o1eVZ0bqD4kE1rTtQe9C','admin','2026-10-14 13:30:00'),
('Zanele Dube','zanele@quickfix.co.za','$2y$10$M0eXl7cSVjQ0Yk3u6hTg3uH5ZJ0t1pQy6o1eVZ0bqD4kE1rTtQe9C','front-desk','2026-10-18 08:45:00'),
('Johan Botha','johan@quickfix.co.za','$2y$10$M0eXl7cSVjQ0Yk3u6hTg3uH5ZJ0t1pQy6o1eVZ0bqD4kE1rTtQe9C','front-desk','2026-10-13 09:15:00');

-- ---------------------------------------------------------------------------
-- app_user (12 rows) - Firebase UIDs are simulated
-- ---------------------------------------------------------------------------
INSERT INTO app_user (firebase_uid, full_name, email, phone, auth_provider, email_verified, last_login) VALUES
('uid_7Hq2Lm9XpR4tVbN1','Katlego Maile','katlego.maile@example.co.za','0821234567','password',1,'2026-10-18 07:40:00'),
('uid_3Kd8Np2WqT6yZcM4','Lerato Nkosi','lerato.nkosi@example.co.za','0732345678','google.com',1,'2026-10-18 12:15:00'),
('uid_9Bf5Gt1JxC7vQaL2','Sipho Dlamini','sipho.dlamini@example.co.za','0763456789','password',1,'2026-10-17 18:22:00'),
('uid_2Wc6Rh4MnY8kPdS3','Chantelle Fourie','chantelle.fourie@example.co.za','0824567890','google.com',1,'2026-10-18 09:30:00'),
('uid_5Vn1Qz7LbX3mTgH8','Ayanda Mthembu','ayanda.mthembu@example.co.za','0715678901','password',0,'2026-10-16 20:05:00'),
('uid_8Jr4Yd6PkW2cNfA1','Rudolf Steyn','rudolf.steyn@example.co.za','0836789012','password',1,'2026-10-15 11:48:00'),
('uid_1Ts9Xe3HvB5nLqK7','Naledi Mabaso','naledi.mabaso@example.co.za','0747890123','google.com',1,'2026-10-18 06:12:00'),
('uid_6Mp2Cf8RtZ4jVbD5','Imraan Khan','imraan.khan@example.co.za','0828901234','password',1,'2026-10-14 15:35:00'),
('uid_4Ld7Kw5NsQ1xHcG9','Bontle Sithole','bontle.sithole@example.co.za','0739012345','password',1,'2026-10-17 13:20:00'),
('uid_0Gy3Bv9TmJ6pRnE2','Marius du Plessis','marius.duplessis@example.co.za','0810123456','google.com',1,'2026-10-13 17:02:00'),
('uid_7Zq8Hn2VdL4sWcF6','Thandeka Zulu','thandeka.zulu@example.co.za','0791234560','password',1,'2026-10-18 10:48:00'),
('uid_5Ab1Mj7QrN3tYhX4','Kgosi Molefe','kgosi.molefe@example.co.za','0602345671','password',0,'2026-10-12 08:30:00');

-- ---------------------------------------------------------------------------
-- repair_pricing (16 rows across all four categories)
-- ---------------------------------------------------------------------------
INSERT INTO repair_pricing (category, service_part_name, description, estimated_price, is_active) VALUES
('Screen Replacement','Standard 15.6" HD LED screen','Common in HP, Dell and Lenovo entry models','R1,850',1),
('Screen Replacement','15.6" Full HD IPS screen','Sharper panel used in mid-range business laptops','R2,450',1),
('Screen Replacement','14" Full HD touch screen','Touch digitiser and panel assembly','R3,200',1),
('Screen Replacement','MacBook Air 13" retina display','Genuine-grade replacement assembly','From R6,500',1),
('Battery & Power','Standard replacement battery','Most HP, Dell, Lenovo and Asus models','R1,100',1),
('Battery & Power','High-capacity replacement battery','Extended runtime where the model supports it','R1,650',1),
('Battery & Power','DC power jack repair','Charging port re-solder or replacement','R850',1),
('Battery & Power','Replacement charger','Original-specification power adapter','R650',1),
('SSD & RAM Upgrades','512GB NVMe SSD upgrade','Includes cloning of your existing drive','R1,450',1),
('SSD & RAM Upgrades','1TB NVMe SSD upgrade','Includes cloning of your existing drive','R2,300',1),
('SSD & RAM Upgrades','8GB DDR4 memory module','Fitted and tested','R750',1),
('SSD & RAM Upgrades','16GB DDR4 memory module','Fitted and tested','R1,350',1),
('Motherboard & Logic','Component-level diagnostics','Free when the repair is booked with us','R0',1),
('Motherboard & Logic','Power circuit repair','Dead or non-charging boards','From R1,900',1),
('Motherboard & Logic','Liquid damage ultrasonic clean','Includes corrosion treatment','From R1,500',1),
('Motherboard & Logic','BGA chip reball or replacement','Graphics or bridge chip faults','From R3,500',1);

-- ---------------------------------------------------------------------------
-- repair_booking (12 rows)
-- ---------------------------------------------------------------------------
INSERT INTO repair_booking
(reference, user_id, full_name, phone, email, device_brand, device_model, primary_issue, description, status, submitted_date, admin_notes) VALUES
('QF-2026-00031',1,'Katlego Maile','0821234567','katlego.maile@example.co.za','Dell','XPS 15 9500','Screen Damage','The laptop fell off my desk and the screen now shows coloured lines across the lower half.','Resolved','2026-09-28 09:15:00','Panel replaced, tested, collected.'),
('QF-2026-00032',2,'Lerato Nkosi','0732345678','lerato.nkosi@example.co.za','HP','Pavilion 15-eh1','Battery Issues','The battery drains from full to flat in about forty minutes even when idle.','Resolved','2026-09-30 14:02:00','Battery replaced under parts warranty.'),
('QF-2026-00033',3,'Sipho Dlamini','0763456789','sipho.dlamini@example.co.za','Lenovo','ThinkPad T490','Slow Performance','Boot takes over four minutes and the machine freezes when I open more than two tabs.','Resolved','2026-10-02 11:30:00','Upgraded to 512GB NVMe and 16GB RAM.'),
('QF-2026-00034',4,'Chantelle Fourie','0824567890','chantelle.fourie@example.co.za','Apple','MacBook Air M1 2020','Water Damage','I spilled coffee on the keyboard and the machine will not switch on at all now.','In Progress','2026-10-08 08:45:00','Ultrasonic clean done, awaiting board test.'),
('QF-2026-00035',5,'Ayanda Mthembu','0715678901','ayanda.mthembu@example.co.za','Asus','VivoBook X515','Data Recovery','The drive is not detected in the BIOS and I need my final year project files back.','In Progress','2026-10-09 16:20:00','Drive imaged, 82 percent recovered so far.'),
('QF-2026-00036',6,'Rudolf Steyn','0836789012','rudolf.steyn@example.co.za','Acer','Aspire 5 A515','Motherboard Fault','No power at all, no lights, even with a known working charger connected.','Contacted','2026-10-11 10:05:00','Quoted R1,900 for power circuit repair.'),
('QF-2026-00037',7,'Naledi Mabaso','0747890123','naledi.mabaso@example.co.za','HP','EliteBook 840 G7','Screen Damage','There is a cracked corner on the display and the touch no longer responds there.','Ready for Pickup','2026-10-12 13:40:00','Touch assembly replaced and tested.'),
('QF-2026-00038',8,'Imraan Khan','0828901234','imraan.khan@example.co.za','Dell','Latitude 5420','Battery Issues','Battery reports as not detected and the laptop only runs when plugged in.','Contacted','2026-10-13 09:55:00','Awaiting customer approval on quote.'),
('QF-2026-00039',9,'Bontle Sithole','0739012345','bontle.sithole@example.co.za','Lenovo','IdeaPad 3 15ITL','Slow Performance','Everything is sluggish and the fan runs loudly even when I am only browsing.','New','2026-10-15 15:12:00',NULL),
('QF-2026-00040',10,'Marius du Plessis','0810123456','marius.duplessis@example.co.za','Apple','MacBook Pro 13 2019','Other','The keyboard types double letters and the trackpad click is intermittent.','New','2026-10-16 11:08:00',NULL),
('QF-2026-00041',11,'Thandeka Zulu','0791234560','thandeka.zulu@example.co.za','Samsung','Galaxy Book2 Pro','Screen Damage','The screen is completely black although I can hear the machine starting up normally.','New','2026-10-17 08:33:00',NULL),
('QF-2026-00042',12,'Kgosi Molefe','0602345671','kgosi.molefe@example.co.za','HP','ProBook 450 G8','Water Damage','Rain got into my bag and the laptop now powers on but the keyboard is dead.','New','2026-10-18 09:47:00',NULL);

-- ---------------------------------------------------------------------------
-- booking_status_history (15 rows)
-- ---------------------------------------------------------------------------
INSERT INTO booking_status_history (booking_id, status, note, changed_at, changed_by) VALUES
(1,'New','Booking received from the website.','2026-09-28 09:15:00','system'),
(1,'In Progress','Replacement panel fitted.','2026-09-30 10:20:00','Nandi Khumalo'),
(1,'Resolved','Collected and signed for.','2026-10-01 15:05:00','Zanele Dube'),
(2,'New','Booking received from the mobile app.','2026-09-30 14:02:00','system'),
(2,'Resolved','Battery replaced and tested.','2026-10-03 12:40:00','Pieter van Wyk'),
(3,'New','Booking received from the mobile app.','2026-10-02 11:30:00','system'),
(3,'Resolved','SSD and RAM upgrade completed.','2026-10-06 16:15:00','Aisha Patel'),
(4,'New','Booking received from the mobile app.','2026-10-08 08:45:00','system'),
(4,'In Progress','Ultrasonic clean completed, board under test.','2026-10-10 09:30:00','Nandi Khumalo'),
(5,'New','Booking received from the website.','2026-10-09 16:20:00','system'),
(5,'In Progress','Drive imaging started.','2026-10-11 08:10:00','Pieter van Wyk'),
(6,'New','Booking received from the mobile app.','2026-10-11 10:05:00','system'),
(6,'Contacted','Quote sent to the customer by email.','2026-10-12 09:00:00','Lesego Mogara'),
(7,'In Progress','Touch assembly ordered and fitted.','2026-10-14 10:45:00','Aisha Patel'),
(7,'Ready for Pickup','Device tested and waiting at the front desk.','2026-10-16 14:30:00','Zanele Dube');

-- ---------------------------------------------------------------------------
-- trade_in_request (10 rows)
-- ---------------------------------------------------------------------------
INSERT INTO trade_in_request
(user_id, device_type, device_condition, brand_model, storage_capacity, full_name, phone, email, faults_description, status, submitted_date) VALUES
(1,'Laptop','Good','Dell Latitude 7490','256GB','Katlego Maile','0821234567','katlego.maile@example.co.za','Battery holds about two hours, small scuff on the lid, charger included.','Contacted','2026-10-03 10:15:00'),
(2,'iPhone','Excellent','iPhone 13 Pro','128GB','Lerato Nkosi','0732345678','lerato.nkosi@example.co.za','Battery health 91 percent, no cracks, iCloud removed, box and cable included.','Resolved','2026-10-05 12:00:00'),
(3,'Laptop','Fair','HP ProBook 440 G6','500GB','Sipho Dlamini','0763456789','sipho.dlamini@example.co.za','Keyboard has two sticky keys and the hinge is loose, otherwise working.','New','2026-10-07 09:25:00'),
(4,'iPhone','Good','iPhone 12','64GB','Chantelle Fourie','0824567890','chantelle.fourie@example.co.za','Screen replaced last year, battery health 84 percent, no activation lock.','Contacted','2026-10-09 15:40:00'),
(5,'Laptop','Poor','Acer Aspire 3 A315','1TB HDD','Ayanda Mthembu','0715678901','ayanda.mthembu@example.co.za','Does not power on, no charger, screen bezel cracked.','New','2026-10-10 11:55:00'),
(6,'Laptop','Excellent','Lenovo ThinkPad X1 Carbon Gen 9','512GB','Rudolf Steyn','0836789012','rudolf.steyn@example.co.za','Barely used, full box, original charger, no marks at all.','Resolved','2026-10-11 08:05:00'),
(7,'iPhone','Fair','iPhone 11','128GB','Naledi Mabaso','0747890123','naledi.mabaso@example.co.za','Rear glass cracked, screen fine, battery health 78 percent.','New','2026-10-13 14:20:00'),
(8,'Laptop','Good','Asus ZenBook 14 UX425','512GB','Imraan Khan','0828901234','imraan.khan@example.co.za','Light scratches on the palm rest, battery about four hours, charger included.','Contacted','2026-10-14 16:35:00'),
(9,'iPhone','Excellent','iPhone 14','256GB','Bontle Sithole','0739012345','bontle.sithole@example.co.za','Always in a case and screen protector, battery health 97 percent.','New','2026-10-16 10:10:00'),
(10,'Laptop','Fair','MacBook Pro 13 2017','256GB','Marius du Plessis','0810123456','marius.duplessis@example.co.za','Butterfly keyboard repeats keys, battery swollen slightly, no charger.','New','2026-10-17 13:05:00');

-- ---------------------------------------------------------------------------
-- purchase_enquiry (10 rows)
-- ---------------------------------------------------------------------------
INSERT INTO purchase_enquiry
(user_id, full_name, phone, email, device_wanted, budget, preferred_brand, main_use, additional_preferences, status, submitted_date) VALUES
(2,'Lerato Nkosi','0732345678','lerato.nkosi@example.co.za','Laptop',6500.00,'Lenovo','University coursework','At least 8GB RAM and an SSD, 14 inch or smaller please.','Contacted','2026-10-04 09:30:00'),
(3,'Sipho Dlamini','0763456789','sipho.dlamini@example.co.za','Laptop',9000.00,'Dell','Business and accounting','Needs a numeric keypad and good battery life.','New','2026-10-06 11:12:00'),
(5,'Ayanda Mthembu','0715678901','ayanda.mthembu@example.co.za','Laptop',4500.00,NULL,'School work','Anything reliable that runs Office and a browser smoothly.','Resolved','2026-10-08 14:45:00'),
(7,'Naledi Mabaso','0747890123','naledi.mabaso@example.co.za','Phone',5000.00,'Samsung','Daily use and photography','Good camera and at least 128GB storage.','New','2026-10-10 08:20:00'),
(8,'Imraan Khan','0828901234','imraan.khan@example.co.za','Laptop',14000.00,'Apple','Design and video editing','Prefer 16GB RAM, retina display, any recent MacBook.','Contacted','2026-10-11 15:30:00'),
(9,'Bontle Sithole','0739012345','bontle.sithole@example.co.za','Laptop',7200.00,'HP','Remote work','Lightweight with a backlit keyboard would be ideal.','New','2026-10-12 10:40:00'),
(11,'Thandeka Zulu','0791234560','thandeka.zulu@example.co.za','Phone',3500.00,NULL,'Calls and WhatsApp','Battery life matters more than the camera.','New','2026-10-14 12:05:00'),
(12,'Kgosi Molefe','0602345671','kgosi.molefe@example.co.za','Laptop',11000.00,'Asus','Gaming and programming','Dedicated graphics card, 16GB RAM, 512GB SSD minimum.','Contacted','2026-10-15 17:25:00'),
(1,'Katlego Maile','0821234567','katlego.maile@example.co.za','Laptop',8000.00,'Dell','Second machine for home','Something small and quiet for browsing and documents.','New','2026-10-17 09:10:00'),
(4,'Chantelle Fourie','0824567890','chantelle.fourie@example.co.za','Phone',8500.00,'Apple','Work and personal','Prefer an iPhone 13 or newer with at least 128GB.','New','2026-10-18 11:35:00');

-- ---------------------------------------------------------------------------
-- notification_log (14 rows)
-- ---------------------------------------------------------------------------
INSERT INTO notification_log (submission_type, submission_id, recipient_email, email_type, sent_date, status, error_message) VALUES
('RepairBooking',1,'katlego.maile@example.co.za','VisitorConfirmation','2026-09-28 09:15:12','Sent',NULL),
('RepairBooking',1,'support@quickfix.co.za','AdminAlert','2026-09-28 09:15:14','Sent',NULL),
('RepairBooking',2,'lerato.nkosi@example.co.za','VisitorConfirmation','2026-09-30 14:02:08','Sent',NULL),
('RepairBooking',2,'support@quickfix.co.za','AdminAlert','2026-09-30 14:02:09','Sent',NULL),
('RepairBooking',4,'chantelle.fourie@example.co.za','VisitorConfirmation','2026-10-08 08:45:05','Sent',NULL),
('RepairBooking',5,'ayanda.mthembu@example.co.za','VisitorConfirmation','2026-10-09 16:20:11','Failed','SMTP 550: mailbox temporarily unavailable'),
('RepairBooking',5,'support@quickfix.co.za','AdminAlert','2026-10-09 16:20:12','Sent',NULL),
('TradeInRequest',2,'lerato.nkosi@example.co.za','VisitorConfirmation','2026-10-05 12:00:07','Sent',NULL),
('TradeInRequest',5,'ayanda.mthembu@example.co.za','VisitorConfirmation','2026-10-10 11:55:04','Sent',NULL),
('TradeInRequest',5,'support@quickfix.co.za','AdminAlert','2026-10-10 11:55:06','Sent',NULL),
('PurchaseEnquiry',1,'lerato.nkosi@example.co.za','VisitorConfirmation','2026-10-04 09:30:03','Sent',NULL),
('PurchaseEnquiry',4,'naledi.mabaso@example.co.za','VisitorConfirmation','2026-10-10 08:20:05','Sent',NULL),
('PurchaseEnquiry',8,'kgosi.molefe@example.co.za','VisitorConfirmation','2026-10-15 17:25:09','Failed','SMTP timeout after 30s'),
('PurchaseEnquiry',8,'support@quickfix.co.za','AdminAlert','2026-10-15 17:25:11','Sent',NULL);
