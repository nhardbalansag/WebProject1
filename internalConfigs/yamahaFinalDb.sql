create database yamaha_capstone_project;

CREATE TABLE IF NOT EXISTS customer_information (
    ci_id INT AUTO_INCREMENT NOT NULL,
    ci_email VARCHAR(100) NOT NULL,
    ci_firstname VARCHAR(100) NOT NULL,
    ci_lastname VARCHAR(100) NOT NULL,
    ci_middlename VARCHAR(100),
    ci_street VARCHAR(100) NOT NULL,
    ci_city_municipality VARCHAR(100) NOT NULL,
    ci_province VARCHAR(100) NOT NULL,
    ci_zipcode VARCHAR(100) NOT NULL,
    ci_phonenumber VARCHAR(100) NOT NULL,
    ci_telephonenumber VARCHAR(100) NOT NULL,
    ci_bday DATE NOT NULL,
    ci_dateCreated DATE NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (ci_id)
);

CREATE TABLE IF NOT EXISTS admin_information (
    admin_id INT AUTO_INCREMENT NOT NULL,
    admin_email VARCHAR(100) NOT NULL,
    admin_firstname VARCHAR(100) NOT NULL,
    admin_lastname VARCHAR(100) NOT NULL,
    admin_middlename VARCHAR(100),
    admin_street VARCHAR(100) NOT NULL,
    admin_city_municipality VARCHAR(100) NOT NULL,
    admin_province VARCHAR(100) NOT NULL,
    admin_zipcode VARCHAR(100) NOT NULL,
    admin_phonenumber VARCHAR(100) NOT NULL,
    admin_telephonenumber VARCHAR(100) NOT NULL,
    admin_bday DATE NOT NULL,
    admin_dateCreated DATE NOT NULL,
    admin_salt VARCHAR(100) NOT NULL,
    admin_computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (admin_id)
);

CREATE TABLE IF NOT EXISTS customer_account (
    ca_id INT AUTO_INCREMENT NOT NULL,
    ca_date_created DATETIME NOT NULL,
    ca_email VARCHAR(100) NOT NULL,
    cal_password VARCHAR(100) NOT NULL,
    ci_id INT NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (ca_id),
    FOREIGN KEY (ci_id)
        REFERENCES customer_information (ci_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS document_category_type (
    dc_id INT AUTO_INCREMENT NOT NULL,
    dc_document_category_name VARCHAR(100) NOT NULL,
    dc_document_category_description VARCHAR(500) NOT NULL,
    salt VARCHAR(100) NOT NULL,
    dc_date_created DATE NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (dc_id)
);

CREATE TABLE IF NOT EXISTS document (
    d_id INT AUTO_INCREMENT NOT NULL,
    d_image VARCHAR(100) NOT NULL,
    d_status VARCHAR(100) NOT NULL,
    d_note TEXT NOT NULL,
    dc_id INT NOT NULL,
    ca_id INT NOT NULL,
    d_datecreated DATE NOT NULL,
    d_salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (d_id),
    FOREIGN KEY (dc_id)
        REFERENCES document_category_type (dc_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ca_id)
        REFERENCES customer_account (ca_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS penalty (
    penalty_id INT AUTO_INCREMENT NOT NULL,
    penalty_date DATE NOT NULL,
    penalty_status VARCHAR(100) NOT NULL,
    penalty_amount VARCHAR(100) NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (penalty_id)
);

CREATE TABLE IF NOT EXISTS Message (
    m_id INT AUTO_INCREMENT NOT NULL,
    m_message TEXT,
    m_type VARCHAR(100),
    m_salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (m_id)
);

CREATE TABLE IF NOT EXISTS CreatedInquiries (
    ci_id INT AUTO_INCREMENT NOT NULL,
    createdInquiresDate DATE NOT NULL,
    createdInquirestime TIME NOT NULL,
    m_id INT NOT NULL,
    cinfo_id INT NOT NULL,
    PRIMARY KEY (ci_id),
    FOREIGN KEY (m_id)
        REFERENCES Message (m_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (cinfo_id)
        REFERENCES customer_information (ci_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS createdCustomerMessage (
    ccm_id INT AUTO_INCREMENT NOT NULL,
    m_id INT NOT NULL,
    ca_id INT NOT NULL,
    dateCreated DATETIME NOT NULL,
    messageStatus VARCHAR(100),
    PRIMARY KEY (ccm_id),
    FOREIGN KEY (m_id)
        REFERENCES Message (m_id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (ca_id)
        REFERENCES customer_account (ca_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS user_role (
    ur_id INT AUTO_INCREMENT NOT NULL,
    ur_tittle VARCHAR(100) NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (ur_id)
);

CREATE TABLE IF NOT EXISTS admin_account (
    a_id INT AUTO_INCREMENT NOT NULL,
    a_email VARCHAR(100) NOT NULL,
    a_currentpassword VARCHAR(100) NOT NULL,
    a_prevpassword VARCHAR(100) NOT NULL,
    a_datecreated DATE NOT NULL,
    a_dateupdated DATE NOT NULL,
    ur VARCHAR(100) NOT NULL,
    admin_id INT NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (a_id),
    FOREIGN KEY (admin_id)
        REFERENCES admin_information (admin_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS createSupportMessage_to_Account (
    csmta_id INT AUTO_INCREMENT NOT NULL,
    csmta_dateCreated DATE NOT NULL,
    csmta_timeCreated TIME NOT NULL,
    m_id INT NOT NULL,
    a_id INT NOT NULL,
    createdCustomerAccountMessage_id INT NOT NULL,
    PRIMARY KEY (csmta_id),
    FOREIGN KEY (m_id)
        REFERENCES Message (m_id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (a_id)
        REFERENCES admin_account (a_id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (createdCustomerAccountMessage_id)
        REFERENCES createdCustomerMessage (ccm_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS createSupportMessage_to_Inquiry (
    csmti_id INT AUTO_INCREMENT NOT NULL,
    csmti_dateCreated DATE NOT NULL,
    csmti_timeCreated TIME NOT NULL,
    m_id INT NOT NULL,
    a_id INT NOT NULL,
    createdInquiry_id INT NOT NULL,
    PRIMARY KEY (csmti_id),
    FOREIGN KEY (m_id)
        REFERENCES Message (m_id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (a_id)
        REFERENCES admin_account (a_id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (createdInquiry_id)
        REFERENCES CreatedInquiries (ci_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS service (
    service_id INT AUTO_INCREMENT NOT NULL,
    service_type_tittle VARCHAR(100) NOT NULL,
    service_description TEXT NOT NULL,
    service_date_created DATE NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (service_id)
);

CREATE TABLE IF NOT EXISTS product_category_type (
    pct_id INT AUTO_INCREMENT NOT NULL,
    pct_tittle VARCHAR(100) NOT NULL,
    pct_description TEXT NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (pct_id)
);

CREATE TABLE IF NOT EXISTS product (
    p_id INT AUTO_INCREMENT NOT NULL,
    p_Imagelook VARCHAR(100) NOT NULL,
    p_name VARCHAR(100) NOT NULL,
    p_caption VARCHAR(100) NOT NULL,
    p_price VARCHAR(100) NOT NULL,
    p_description TEXT NOT NULL,
    p_datecreated DATE NOT NULL,
    p_datemodified DATE NOT NULL,
    pct_id INT NOT NULL,
	salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (p_id),
    FOREIGN KEY (pct_id)
        REFERENCES product_category_type (pct_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS created_product (
    cp_id INT AUTO_INCREMENT NOT NULL,
    cp_status VARCHAR(100) NOT NULL,
    p_id INT NOT NULL,
    cp_dateCreated DATE NOT NULL,
    PRIMARY KEY (cp_id),
    FOREIGN KEY (p_id)
        REFERENCES product (p_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);		


CREATE TABLE availed_customer_information (
    aci_id INT AUTO_INCREMENT NOT NULL,
    aci_dateCreated DATE NOT NULL,
    aci_dateModified DATE NOT NULL,
    aci_firstName VARCHAR(100) NOT NULL,
    aci_lastName VARCHAR(100) NOT NULL,
    aci_middleName VARCHAR(100) NOT NULL,
    aci_address TEXT NOT NULL,
    aci_billingAddress TEXT NOT NULL,
    aci_emailAddress VARCHAR(100) NOT NULL,
    ca_id INT NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (aci_id),
    FOREIGN KEY (ca_id)
        REFERENCES customer_account (ca_id)
);

CREATE TABLE IF NOT EXISTS purchase_information (
    pi_id INT AUTO_INCREMENT NOT NULL,
    pi_date DATE NOT NULL,
    pi_purchaseType VARCHAR(100) NOT NULL,
    cp_id INT NOT NULL,
    aci_id INT NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (pi_id),
    FOREIGN KEY (cp_id)
        REFERENCES created_product (cp_id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (aci_id)
        REFERENCES availed_customer_information (aci_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS transaction_information (
    ti_id INT AUTO_INCREMENT NOT NULL,
    ti_date DATETIME NOT NULL,
    ti_dateUpdated DATE NOT NULL,
    ti_previousBalance VARCHAR(100) NOT NULL,
    ti_paidAmount VARCHAR(100) NOT NULL,
    ti_status VARCHAR(100) NOT NULL,
    ti_totalPaidAmount VARCHAR(100) NOT NULL,
    ti_currentBalance VARCHAR(100) NOT NULL,
    aci_id INT NOT NULL,
    pi_id INT NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (ti_id),
    FOREIGN KEY (aci_id)
        REFERENCES availed_customer_information (aci_id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (pi_id)
        REFERENCES purchase_information (pi_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE penalty_payment (
    penalty_payment_id INT AUTO_INCREMENT NOT NULL,
    payment BIGINT NOT NULL,
    penaltyAmount BIGINT NOT NULL,
    balance BIGINT NOT NULL,
    payment_status VARCHAR(100) NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (penalty_payment_id)
);

CREATE TABLE penalty_balance (
    penalty_balance_id INT AUTO_INCREMENT NOT NULL,
    balance BIGINT NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (penalty_balance_id)
);

CREATE TABLE penalty_transaction (
    penalty_transaction_id INT AUTO_INCREMENT NOT NULL,
    date_created DATETIME NOT NULL,
    date_updated DATETIME NOT NULL,
    ti_id INT NOT NULL,
    penalty_payment_id INT NOT NULL,
    penalty_balance_id INT NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (penalty_transaction_id),
    FOREIGN KEY (ti_id)
        REFERENCES transaction_information (ti_id),
    FOREIGN KEY (penalty_payment_id)
        REFERENCES penalty_payment (penalty_payment_id),
    FOREIGN KEY (penalty_balance_id)
        REFERENCES penalty_balance (penalty_balance_id)
);

CREATE TABLE penalty_balance_payment (
    penalty_balance_payment_id INT AUTO_INCREMENT NOT NULL,
    date_created DATETIME NOT NULL,
    payment BIGINT NOT NULL,
    payment_status VARCHAR(100) NOT NULL,
    penalty_transaction_id INT NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (penalty_balance_payment_id),
    FOREIGN KEY (penalty_transaction_id)
        REFERENCES penalty_transaction (penalty_transaction_id)
);

CREATE TABLE IF NOT EXISTS colors (
    c_id INT AUTO_INCREMENT NOT NULL,
    c_name VARCHAR(100),
    p_id INT NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (c_id),
    FOREIGN KEY (p_id)
        REFERENCES product (p_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS specification (
    s_id INT AUTO_INCREMENT NOT NULL,
    s_specification_type VARCHAR(100) NOT NULL,
    s_description TEXT NOT NULL,
    s_category VARCHAR(100) NOT NULL,
    p_id INT NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (s_id),
    FOREIGN KEY (p_id)
        REFERENCES product (p_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);	


CREATE TABLE IF NOT EXISTS features (
    f_id INT AUTO_INCREMENT NOT NULL,
    f_image VARCHAR(100) NOT NULL,
    f_tittle VARCHAR(100) NOT NULL,
    f_description TEXT NOT NULL,
    f_created DATE NOT NULL,
    f_modified DATE NOT NULL,
    p_id INT NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (f_id),
    FOREIGN KEY (p_id)
        REFERENCES product (p_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);	

CREATE TABLE IF NOT EXISTS branch_information (
    bi_id INT AUTO_INCREMENT NOT NULL,
    bi_name VARCHAR(100) NOT NULL,
    bi_street VARCHAR(100) NOT NULL,
    bi_city_municipality VARCHAR(100) NOT NULL,
    bi_buildingNumber VARCHAR(100) NOT NULL,
    bi_about TEXT NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (bi_id)
);


CREATE TABLE IF NOT EXISTS email (
    e_id INT AUTO_INCREMENT NOT NULL,
    e_address VARCHAR(100) NOT NULL,
    e_description VARCHAR(100) NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (e_id)
);	

CREATE TABLE IF NOT EXISTS links (
    l_id INT AUTO_INCREMENT NOT NULL,
    l_address VARCHAR(100) NOT NULL,
    l_description VARCHAR(100) NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (l_id)
);	


CREATE TABLE IF NOT EXISTS contact (
    c_id INT AUTO_INCREMENT NOT NULL,
    c_number VARCHAR(100) NOT NULL,
    c_category VARCHAR(100) NOT NULL,
    salt VARCHAR(100) NOT NULL,
    computed_hash VARCHAR(100) NOT NULL,
    PRIMARY KEY (c_id)
);	

	

-- CREATE TABLE IF NOT EXISTS loggedReports (
--    logged_id int auto_increment not null,
--    logged_role varchar(100) not null,
--    logged_browser varchar(100) not null,
--    logged_location varchar(100) not null,
--    logged_datetime datetime not null,
--    logged_account_id int not null,
--    logged_account_name varchar(100) not null,
--    logged_session_id varchar(100) not null,
--    logged_status_code varchar(100) not null,
--    primary key(logged_id)
-- ); 	

-- CREATE TABLE IF NOT EXISTS actionsLoggedReport (
--    actionlogged_id int auto_increment not null,
--    actionlogged_method varchar(100) not null,
--    actionlogged_data_id int not null,
--    actionlogged_data_tittle varchar(100) not null,
--    actionlogged_datetime datetime not null,
--    primary key(actionlogged_id)
-- ); 	









