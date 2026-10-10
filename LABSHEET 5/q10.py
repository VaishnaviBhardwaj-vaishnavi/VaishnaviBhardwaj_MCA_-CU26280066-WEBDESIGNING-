
from db_config import connect_db

con = connect_db()
cur = con.cursor()

name = input("Enter name to search: ")

cur.execute(
    "SELECT * FROM users WHERE name = %s",
    (name,)
)

for row in cur.fetchall():
    print(row)

cur.close()
con.close()
