
from mysql.connector import pooling

pool = pooling.MySQLConnectionPool(
    pool_name="mypool",
    pool_size=5,
    host="localhost",
    user="root",
    password="your_password",
    database="python_web_db"
)

con = pool.get_connection()
cur = con.cursor()

cur.execute("SELECT COUNT(*) FROM users")
print("Total users:", cur.fetchone()[0])

cur.close()
con.close()
