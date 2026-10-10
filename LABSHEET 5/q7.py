
from db_config import connect_db

con = connect_db()
cur = con.cursor()

user_id = int(input("Enter user ID: "))
name = input("Enter new name: ")
email = input("Enter new email: ")

cur.execute(
    "UPDATE users SET name=%s, email=%s WHERE id=%s",
    (name, email, user_id)
)

con.commit()
print(cur.rowcount, "record updated")

cur.close()
con.close()
