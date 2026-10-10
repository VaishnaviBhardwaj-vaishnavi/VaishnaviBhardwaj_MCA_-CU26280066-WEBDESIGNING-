
import re
from db_config import connect_db

name = input("Enter name: ").strip()
email = input("Enter email: ").strip()
age_text = input("Enter age: ").strip()

if not re.fullmatch(r"[A-Za-z ]{1,50}", name):
    print("Invalid name")
elif not re.fullmatch(r"[^@\s]+@[^@\s]+\.[^@\s]+", email):
    print("Invalid email")
elif not age_text.isdigit() or not 1 <= int(age_text) <= 120:
    print("Invalid age")
else:
    con = connect_db()
    cur = con.cursor()

    cur.execute(
        "INSERT INTO users (name, email, age) VALUES (%s, %s, %s)",
        (name, email, int(age_text))
    )
    con.commit()

    print("Valid data inserted successfully")
    cur.close()
    con.close()
