
from db_config import connect_db
import mysql.connector

try:
    con = connect_db()
    cur = con.cursor()

    user_id = int(input("Enter user ID to delete: "))

    cur.execute("DELETE FROM users WHERE id=%s", (user_id,))
    con.commit()

    print(cur.rowcount, "record deleted")

except (mysql.connector.Error, ValueError) as e:
    print("Error:", e)

finally:
    if "cur" in locals():
        cur.close()
    if "con" in locals() and con.is_connected():
        con.close()
