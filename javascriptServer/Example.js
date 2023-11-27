const connection = require("./conn");
const express = require("express");
const jwt = require("jsonwebtoken");
const fs = require("fs");

const app = express();

const conn = connection();

// Secret key for signing and verifying the JWT
const secretKey = 'your-secret-key';

app.post("/login", (req, res) => {
  const { username, password } = req.body;

  // Check if the user exists and the password is correct (in a real application, this would involve database queries)
  const user =true
  if (user) {
    // Generate a JWT token
    const token = jwt.sign(
      { userId: user.id, username: user.username },
      secretKey,
      { expiresIn: "1h" }
    );

    res.json({ token });
  } else {
    res.status(401).json({ message: "Invalid credentials" });
  }
});


app.get("/protected", authenticateToken, (req, res) => {
  res.json({ message: "This is a protected resource" });
});

function authenticateToken(req, res, next) {
  const token = req.header("Authorization");

  if (!token) return res.status(401).json({ message: "Unauthorized" });

  jwt.verify(token, secretKey, (err, user) => {
    if (err) return res.status(403).json({ message: "Forbidden" });

    req.user = user;
    next();
  });
}

app.get("/", (req, res) => {
  let file;
  fs.readFile("../javascriptclient/Home.html", (err, result) => {
    if (err) {
      console.log(err);
    } else {
      file = result.toString();
      res.send(file);
      console.log(file);
    }
  });
});

app.get("/value", (req, res) => {
  res.send({key:'value'});
});

app.listen(4000, () => {
  console.error("listening on port 4000");
});
