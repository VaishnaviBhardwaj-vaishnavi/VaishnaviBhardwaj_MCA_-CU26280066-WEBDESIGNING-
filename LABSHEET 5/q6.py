
import cgi
from db_config import connect_db

print("Content-Type: text/html\n")

form = cgi.FieldStorage()
name = form.getfirst("name", "").strip()
email = form.getfirst("email", "").strip()

if name and email and len(name) <= 50 and len(email) <= 100:
    con = connect_db()
    cur = con.cursor()

    cur.execute(
        "INSERT INTO users (name, email, age) VALUES (%s, %s, %s)",
        (name, email, 18)
    )
    con.commit()

    print("<h2>User inserted successfully!</h2>")
    cur.close()
    con.close()
else:
    print("<h2>Please enter valid name and email.</h2>")
