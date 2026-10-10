
import mysql.connector

con = mysql.connector.connect(
    host="localhost",
    user="root",
    password="your_password"
)

cur = con.cursor()
cur.execute("SELECT VERSION()")

print("MySQL Version:", cur.fetchone()[0])

cur.close()
con.close()
