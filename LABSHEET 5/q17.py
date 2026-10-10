
import secrets
from db_config import connect_db

con = connect_db()
cur = con.cursor()

cur.execute("""
CREATE TABLE IF NOT EXISTS user_sessions (
    token VARCHAR(64) PRIMARY KEY,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
""")

token = secrets.token_hex(24)
user_id = int(input("Enter user ID: "))

cur.execute("SELECT id FROM users WHERE id=%s", (user_id,))
if cur.fetchone():
    cur.execute(
        "INSERT INTO user_sessions (token, user_id) VALUES (%s, %s)",
        (token, user_id)
    )
    con.commit()
    print("Session created:", token)
else:
    print("User not found")

cur.close()
con.close()
