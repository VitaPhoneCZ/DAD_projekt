const mysql = require('mysql2');

const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "ticket_system"
});

db.connect((err) => {
    if (err) {
        console.error("MySQL connection failed: " + err.message);
    } else {
        console.log("Connected to MySQL!");
    }
});

module.exports = db;