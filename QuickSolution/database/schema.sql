-- ===========================================================================
-- QuickFix Laptop Solutions - database schema
-- DBMS: MySQL 8.0 / MariaDB 10.6+       Database: quickfix_db
-- Task 2, XISD6329 - Work Integrated Learning
--
-- Note on naming: the Task 1 design document names the trade-in column
-- "condition". CONDITION is a reserved word in MySQL, so it is implemented
-- here as device_condition. Every other column matches the design document.
-- ===========================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS notification_log;
DROP TABLE IF EXISTS booking_status_history;
DROP TABLE IF EXISTS purchase_enquiry;
DROP TABLE IF EXISTS trade_in_request;
DROP TABLE IF EXISTS repair_booking;
DROP TABLE IF EXISTS repair_pricing;
DROP TABLE IF EXISTS app_user;
DROP TABLE IF EXISTS admin;

SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------------------------------
-- app_user
-- Mirror of the Firebase Authentication account. The password itself is never
-- stored here: Firebase holds a salted hash and QuickFix holds only the UID.
-- ---------------------------------------------------------------------------
CREATE TABLE app_user (
    user_id        INT AUTO_INCREMENT PRIMARY KEY,
    firebase_uid   VARCHAR(128)  NOT NULL UNIQUE,
    full_name      VARCHAR(150)  NOT NULL,
    email          VARCHAR(255)  NOT NULL,
    phone          VARCHAR(15)   NULL,
    auth_provider  ENUM('password','google.com') NOT NULL DEFAULT 'password',
    email_verified TINYINT(1)    NOT NULL DEFAULT 0,
    created_at     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_login     DATETIME      NULL,
    INDEX idx_app_user_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- repair_booking
-- ---------------------------------------------------------------------------
CREATE TABLE repair_booking (
    booking_id     INT AUTO_INCREMENT PRIMARY KEY,
    reference      VARCHAR(20)   NOT NULL UNIQUE,
    user_id        INT           NULL,
    full_name      VARCHAR(150)  NOT NULL,
    phone          VARCHAR(15)   NOT NULL,
    email          VARCHAR(255)  NOT NULL,
    device_brand   VARCHAR(100)  NOT NULL,
    device_model   VARCHAR(150)  NOT NULL,
    primary_issue  VARCHAR(100)  NOT NULL,
    description    TEXT          NOT NULL,
    status         ENUM('New','Contacted','In Progress','Ready for Pickup','Resolved','Cancelled')
                   NOT NULL DEFAULT 'New',
    submitted_date DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    admin_notes    TEXT          NULL,
    CONSTRAINT fk_booking_user FOREIGN KEY (user_id)
        REFERENCES app_user(user_id) ON DELETE SET NULL,
    INDEX idx_booking_status (status),
    INDEX idx_booking_phone (phone)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- booking_status_history - drives the Track Repair screen in the mobile app
-- ---------------------------------------------------------------------------
CREATE TABLE booking_status_history (
    history_id   INT AUTO_INCREMENT PRIMARY KEY,
    booking_id   INT          NOT NULL,
    status       VARCHAR(40)  NOT NULL,
    note         VARCHAR(255) NULL,
    changed_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    changed_by   VARCHAR(150) NULL,
    CONSTRAINT fk_history_booking FOREIGN KEY (booking_id)
        REFERENCES repair_booking(booking_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- trade_in_request
-- ---------------------------------------------------------------------------
CREATE TABLE trade_in_request (
    request_id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id            INT          NULL,
    device_type        ENUM('Laptop','iPhone') NOT NULL,
    device_condition   ENUM('Poor','Fair','Good','Excellent') NOT NULL,
    brand_model        VARCHAR(200) NOT NULL,
    storage_capacity   VARCHAR(50)  NOT NULL,
    full_name          VARCHAR(150) NOT NULL,
    phone              VARCHAR(15)  NOT NULL,
    email              VARCHAR(255) NOT NULL,
    faults_description TEXT         NOT NULL,
    status             ENUM('New','Contacted','Resolved') NOT NULL DEFAULT 'New',
    submitted_date     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    admin_notes        TEXT         NULL,
    CONSTRAINT fk_tradein_user FOREIGN KEY (user_id)
        REFERENCES app_user(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- purchase_enquiry
-- ---------------------------------------------------------------------------
CREATE TABLE purchase_enquiry (
    enquiry_id             INT AUTO_INCREMENT PRIMARY KEY,
    user_id                INT            NULL,
    full_name              VARCHAR(150)   NOT NULL,
    phone                  VARCHAR(15)    NOT NULL,
    email                  VARCHAR(255)   NOT NULL,
    device_wanted          ENUM('Laptop','Phone') NOT NULL,
    budget                 DECIMAL(10,2)  NOT NULL,
    preferred_brand        VARCHAR(100)   NULL,
    main_use               VARCHAR(150)   NOT NULL,
    additional_preferences TEXT           NULL,
    status                 ENUM('New','Contacted','Resolved') NOT NULL DEFAULT 'New',
    submitted_date         DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    admin_notes            TEXT           NULL,
    CONSTRAINT fk_enquiry_user FOREIGN KEY (user_id)
        REFERENCES app_user(user_id) ON DELETE SET NULL,
    CONSTRAINT chk_enquiry_budget CHECK (budget > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- repair_pricing - read by both the website and the mobile Pricing screen
-- ---------------------------------------------------------------------------
CREATE TABLE repair_pricing (
    price_id          INT AUTO_INCREMENT PRIMARY KEY,
    category          ENUM('Screen Replacement','Battery & Power',
                           'SSD & RAM Upgrades','Motherboard & Logic') NOT NULL,
    service_part_name VARCHAR(200) NOT NULL,
    description       VARCHAR(200) NULL,
    estimated_price   VARCHAR(50)  NOT NULL,
    is_active         TINYINT(1)   NOT NULL DEFAULT 1,
    last_updated      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
                                   ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_pricing_category (category, is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- admin - staff accounts for the web admin panel (bcrypt hashes only)
-- ---------------------------------------------------------------------------
CREATE TABLE admin (
    admin_id        INT AUTO_INCREMENT PRIMARY KEY,
    full_name       VARCHAR(150) NOT NULL,
    email           VARCHAR(255) NOT NULL UNIQUE,
    password_hash   VARCHAR(255) NOT NULL,
    role            VARCHAR(50)  NOT NULL DEFAULT 'admin',
    failed_attempts INT          NOT NULL DEFAULT 0,
    locked_until    DATETIME     NULL,
    last_login      DATETIME     NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- notification_log - soft reference to whichever submission triggered the mail
-- ---------------------------------------------------------------------------
CREATE TABLE notification_log (
    log_id          INT AUTO_INCREMENT PRIMARY KEY,
    submission_type ENUM('RepairBooking','TradeInRequest','PurchaseEnquiry') NOT NULL,
    submission_id   INT          NOT NULL,
    recipient_email VARCHAR(255) NOT NULL,
    email_type      ENUM('VisitorConfirmation','AdminAlert') NOT NULL,
    sent_date       DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status          ENUM('Sent','Failed') NOT NULL DEFAULT 'Sent',
    error_message   TEXT         NULL,
    INDEX idx_notify_submission (submission_type, submission_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
