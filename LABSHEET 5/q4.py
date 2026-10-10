
from db_config import connect_db

con = connect_db()
cur = con.cursor()

sql = "INSERT INTO users (name, email, age) VALUES (%s, %s, %s)"

data = [
    ("Aman", "aman@gmail.com", 21),
    ("Riya", "riya@gmail.com", 22),
    ("Rahul", "rahul@gmail.com", 20)
]

cur.executemany(sql, data)
con.commit()

print(cur.rowcount, "records inserted")

cur.close()
con.close()

