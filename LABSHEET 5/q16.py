
import subprocess

try:
    with open("backup.sql", "w") as file:
        subprocess.run(
            [
                "mysqldump",
                "-h", "localhost",
                "-u", "root",
                "-p",
                "python_web_db"
            ],
            stdout=file,
            check=True
        )

    print("Database backup completed!")

except (OSError, subprocess.CalledProcessError) as e:
    print("Backup failed:", e)
