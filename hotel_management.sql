-- 📦 HOTEL MANAGEMENT SYSTEM - FULL DATABASE SCHEMA (MySQL)

-- 🔐 USERS TABLE (Admin, Staff, etc.)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','staff') DEFAULT 'staff',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 🧍 GUESTS TABLE
CREATE TABLE guests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  phone VARCHAR(15),
  id_proof VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 🏨 ROOMS TABLE
CREATE TABLE rooms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  room_number VARCHAR(10) UNIQUE,
  type VARCHAR(50),
  status ENUM('available','booked','maintenance') DEFAULT 'available',
  price DECIMAL(10,2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 📝 BOOKINGS TABLE
CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  guest_id INT,
  room_id INT,
  checkin_date DATE,
  checkout_date DATE,
  status ENUM('booked','checked_in','checked_out','cancelled') DEFAULT 'booked',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (guest_id) REFERENCES guests(id),
  FOREIGN KEY (room_id) REFERENCES rooms(id)
);

-- 💰 PAYMENTS TABLE
CREATE TABLE tbl_payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  booking_id INT,
  amount DECIMAL(10,2),
  payment_mode ENUM('cash','upi','card') DEFAULT 'cash',
  payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (booking_id) REFERENCES bookings(id)
);

-- 🧾 INVOICES TABLE
CREATE TABLE invoices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  booking_id INT,
  invoice_number VARCHAR(20) UNIQUE,
  total_amount DECIMAL(10,2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (booking_id) REFERENCES bookings(id)
);

-- 🧺 SERVICES TABLE (Laundry, Food, etc.)
CREATE TABLE services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  price DECIMAL(10,2),
  description TEXT
);

-- 🧾 SERVICE REQUESTS TABLE
CREATE TABLE service_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  booking_id INT,
  service_id INT,
  quantity INT DEFAULT 1,
  requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (booking_id) REFERENCES bookings(id),
  FOREIGN KEY (service_id) REFERENCES services(id)
);

-- 📦 INVENTORY TABLE
CREATE TABLE inventory (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_name VARCHAR(100),
  quantity INT,
  unit_price DECIMAL(10,2),
  last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 👨‍🔧 STAFF TABLE
CREATE TABLE staff (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  phone VARCHAR(15),
  position VARCHAR(50),
  salary DECIMAL(10,2),
  join_date DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 🕒 ATTENDANCE TABLE
CREATE TABLE staff_attendance (
  id INT AUTO_INCREMENT PRIMARY KEY,
  staff_id INT,
  date DATE,
  status ENUM('present','absent','leave') DEFAULT 'present',
  FOREIGN KEY (staff_id) REFERENCES staff(id)
);

-- 💼 PAYROLL TABLE
CREATE TABLE payroll (
  id INT AUTO_INCREMENT PRIMARY KEY,
  staff_id INT,
  month VARCHAR(20),
  total_present INT,
  total_leave INT,
  net_salary DECIMAL(10,2),
  generated_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (staff_id) REFERENCES staff(id)
);

-- 🛑 ACTIVITY LOG TABLE (Optional)
CREATE TABLE activity_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  action TEXT,
  log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
