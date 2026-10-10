
import mysql.connector

con = mysql.connector.connect(
    host="localhost",
    user="root",
    password="your_password"
)

cur = con.cursor()
cur.execute("CREATE DATABASE IF NOT EXISTS python_web_db")
cur.execute("USE python_web_db")

cur.execute("""
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    email VARCHAR(100),
    age INT
)
""")

print("Database and table created successfully!")

cur.close()
con.close()

