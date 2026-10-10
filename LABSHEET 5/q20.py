
from db_config import connect_db

con = connect_db()
cur = con.cursor()

cur.execute("""
SELECT
    COUNT(*) AS total_users,
    AVG(age) AS average_age
FROM users
""")

result = cur.fetchone()

print("Total Users:", result[0])
print("Average Age:", round(result[1], 2) if result[1] is not None else 0)

cur.close()
con.close()
