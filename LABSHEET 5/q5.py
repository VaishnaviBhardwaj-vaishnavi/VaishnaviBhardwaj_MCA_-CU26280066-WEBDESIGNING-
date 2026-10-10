
from html import escape
from db_config import connect_db

con = connect_db()
cur = con.cursor()
cur.execute("SELECT id, name, email, age FROM users")

html = "<h2>User Records</h2><table border='1'>"
html += "<tr><th>ID</th><th>Name</th><th>Email</th><th>Age</th></tr>"

for row in cur.fetchall():
    html += "<tr>"
    for value in row:
        html += "<td>" + escape(str(value)) + "</td>"
    html += "</tr>"

html += "</table>"

print(html)

cur.close()
con.close()
