db.createUser(
    {
        user: "admin",
        pwd: "admin",
        roles: [
            {
                role: "readWrite",
                db: "crud"
            }
        ]
    }
);
db.createCollection("users");