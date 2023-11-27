const connection = require("./conn");
const express = require("express");
const jwt = require("jsonwebtoken");
const fs = require("fs");
const bcrypt = requir("bcrypt");

const app = express();

const conn = connection();

// Secret key for signing and verifying the JWT
const userAPIkey = "your-secret-key";

app.post("/SignIn", (req, res) => {
  const { username, password } = req.body;
  let user;

  conn.query(
    `SELECT * FROM APIUSERS WHERE USERNAME=${username}`,
    async (err, result) => {
      if (err) {
        console.log(err);
      } else {
        const passHash = result[0].Password;
        const match = await bcrypt.compare(password, passHash);
        if (match) {
          user = result;
        }
      }
    }
  );
  if (user) {
    // Generate a JWT token
    const token = jwt.sign(
      { userId: user.id, username: user.username },
      secretKey,
      { expiresIn: "1h" }
    );

    res.send({ token, proceed: true });
  } else {
    res.send({ proceed: false });
  }
});

app.post("/SignUp", async (req, res) => {
  const { name, username, password, email } = req.body;
  let data = req.body;
  let user;

  const saltRounds = 12;
  const hashedPassword = await bcrypt.hash(password, saltRounds);

  // Generate a random 6-digit verification code
  const generateVerificationCode = () => {
    return Math.floor(10000 + Math.random() * 90000);
  };

  const id = generateVerificationCode();

  delete data.password;
  data.hashedPassword = hashedPassword;

  conn.query(
    `INSERT INTO APIUSERS (APIUSERID,Name, UserName, Email, Password) VALUES(${id},${name},${username},${email},${hashedPassword})`,
    async (err, result) => {
      if (err) {
        console.log(err);
      } else {
        console.log(result);
        user = data;
      }
    }
  );
  if (user) {
    // Generate a JWT token
    const token = jwt.sign(
      { userId: user.id, username: user.username },
      secretKey,
      { expiresIn: "1h" }
    );

    res.send({ token, proceed: true, data: data });
  } else {
    res.send({ proceed: false });
  }
});

app.get("/SignUp", (req, res) => {
  fs.readFile("../javascriptclient/SignUp.html", (err, result) => {
    if (err) {
      console.error(err);
    } else {
      res.send(result.toString());
    }
  });
});

app.get("/Apis/Home", authenticateToken, (req, res) => {
  res.json({ message: "This is a protected resource" });
});

function authenticateToken(req, res, next) {
  const token = req.header("Authorization");

  if (!token) return res.send({ message: "Unauthorized" });

  jwt.verify(token, secretKey, (err, user) => {
    if (err) return res.send({ message: "Forbidden" });
    req.user = user;
    next();
  });
}

app.get("/Hom", (req, res) => {
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
  res.send({ key: "value" });
});

app.listen(4000, () => {
  console.error("listening on port 4000");
});
