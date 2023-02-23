-- Head of Accounts Table
CREATE TABLE hoa(
    id BIGSERIAL PRIMARY KEY,
    mjh INT ,
    mjh_desc VARCHAR(100),
    smjh INT,
    smjh_desc VARCHAR(100),
    mih INT,
    mih_desc VARCHAR(100),
    gsh INT,
    gsh_desc VARCHAR(100),
    sh INT,
    sh_desc VARCHAR(100),
    dh INT,
    dh_desc VARCHAR(100),
    sdh INT,
    sdh_desc VARCHAR(100),
    hoa VARCHAR(20),
    hoa_tier VARCHAR(100)
);

-- Forms Table
CREATE TABLE forms(
    id BIGSERIAL PRIMARY KEY,
    form_number VARCHAR(20) UNIQUE;
);

-- Form Type Table
CREATE TABLE form_types(
    id BIGSERIAL PRIMARY KEY,
    form_type VARCHAR(100),
    forms_id INT REFERENCES forms(id);
);

-- Form Type Hoa Mapping table
CREATE TABLE form_type_hoa_mapping(
    id BIGSERIAL PRIMARY KEY,
    hoa_id INT REFERENCES hoa(id),
    form_type_id INT REFERENCES form_type(id)
);

-- IFSC Code Table
CREATE TABLE ifsc_code(
    id BIGSERIAL PRIMARY KEY,
    ifsc_code VARCHAR(20) UNIQUE,
    bank_name VARCHAR(100),
    state VARCHAR(100),
    branch VARCHAR(100)
);

-- Agencies Table
CREATE TABLE agencies(
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(200),
    account_number VARCHAR(20) UNIQUE,
    ifsc_code INT
);

-- Transacations Table
CREATE TABLE transactions(
    id BIGSERIAL PRIMARY KEY,
    form_type INT;
    form_number varchar(10),
    hoa VARCHAR(20),
    gross BIGINT,
    pt_deduction BIGINT,
    tds BIGINT,
    gst BIGINT,
    gis BIGINT,
    telangana_haritha_nidhi BIGINT,
    net_amount BIGINT,
);

-- Bill Agencies mapping

CREATE TABLE bill_multiple_party(
    id BIGSERIAL PRIMARY KEY,
    transaction_id INT REFERENCES transactions(id),
    agency_name VARCHAR(200),
    agency_account_number VARCHAR(20),
    ifsc_code INT,
    gross BIGINT,
    pt_deduction BIGINT,
    tds BIGINT,
    gst BIGINT,
    gis BIGINT,
    telangana_haritha_nidhi BIGINT,
    net_amount BIGINT,
);

-- Tranasaction Documents

CREATE TABLE attachments(
    id BIGSERIAL PRIMARY KEY,
    file_path varchar(200),
    transaction_id INT REFERENCES transactions(id)
);

CREATE TABLE scrutiny_items(
    id BIGSERIAL PRIMARY KEY,
    description VARCHAR(200),
    form_type_id INT REFERENCES form_type(id)
);

CREATE TABLE scrutiny_answers(
    id BIGSERIAL PRIMARY KEY,
    bill_id INT REFERENCES bills(id);
    question VARCHAR(250),
    asnwer VARCHAR(10)
);
-> bill_id
-> question
-> asnwer




