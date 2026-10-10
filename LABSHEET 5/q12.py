
import logging
from db_config import connect_db

logging.basicConfig(
    filename="server.log",
    level=logging.INFO,
    format="%(asctime)s - %(levelname)s - %(message)s"
)

try:
    con = connect_db()
    cur = con.cursor()
    cur.execute("SELECT * FROM users")
    print(cur.fetchall())

    logging.info("Database query successful")

except Exception:
    logging.exception("Database error")

finally:
    if "cur" in locals():
        cur.close()
    if "con" in locals() and con.is_connected():
        con.close()
