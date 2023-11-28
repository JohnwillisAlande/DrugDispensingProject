const mysql = require("mysql2");

// Create a connection pool
const conn = () => {
  console.log("Connection Established")
  return mysql.createPool({
    host: "localhost",
    user: "root",
    password: "",
    database: "drug_dispensing",
    waitForConnections: true,
  });
};

module.exports = conn;
