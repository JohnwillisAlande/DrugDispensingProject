const connection = require("./conn");
const express = require("express");
const jwt = require("jsonwebtoken");
const fs = require("fs");
const bcrypt = require("bcrypt");

const bodyParser = require("body-parser");
const app = express();

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

const conn = connection();

// Secret key for signing and verifying the JWT
const userkey = "AxSr3fa23gsh2vi9h";

app.post("/SignIn", (req, res) => {
  const { email, password } = req.body;
  let user;

  conn.query(
    `SELECT * FROM API_USERS WHERE Email="${email}"`,
    async (err, result) => {
      if (err) {
        res.send(err);
        return console.log(err);
      } else {
        const passHash = result[0].Password;
        await bcrypt
          .compare(password, passHash)
          .then((match) => {
            if (match) {
              user = result;
              console.log(match, user);
            }
          })
          .then(() => {
            if (user) {
              console.log("xx");
              // Generate a JWT token
              const token = jwt.sign(
                { userId: user.id, username: user.username },
                userkey,
                { expiresIn: "1h" }
              );

              res.send({ token, proceed: true, data: user });
            } else {
              res.send({ proceed: false });
            }
          });
      }
    }
  );
});

// Generate a random 6-digit verification code
const generateVerificationCode = () => {
  return Math.floor(10000 + Math.random() * 90000);
};

app.post("/SignUp", async (req, res) => {
  const { name, username, password, email } = req.body;
  let data = req.body;
  let user;

  const saltRounds = 12;
  const hashedPassword = await bcrypt.hash(password, saltRounds);

  const id = generateVerificationCode();

  delete data.password;
  data.hashedPassword = hashedPassword;

  var sql = `INSERT INTO API_USERS (API_USER_ID, Name, UserName, Email, Password) VALUES(${id}, '${name}', '${username}', '${email}', '${hashedPassword}')`;

  conn.query(sql, async (err, result) => {
    if (err) {
      console.log(err);
    } else {
      console.log(result);
      user = data;
    }
  });
  if (user) {
    // Generate a JWT token
    const token = jwt.sign({ userId: id, username: username }, userkey, {
      expiresIn: "1h",
    });

    res.send({ token, proceed: true, data: data });
  } else {
    res.send({ proceed: false });
  }
});

app.get("/SignUp", (req, res) => {
  fs.readFile("../javascriptClient/SignUp.html", (err, result) => {
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

app.get("/SignIn", (req, res) => {
  fs.readFile("../javascriptclient/SignIn.html", (err, result) => {
    if (err) {
      console.error(err);
    } else {
      res.send(result.toString());
    }
  });
});

function authenticateToken(req, res, next) {
  const token = req.header("Authorization");

  if (!token) return res.send({ message: "Unauthorized" });

  jwt.verify(token, userkey, (err, user) => {
    if (err) return res.send({ message: "Forbidden" });
    req.user = user;
    next();
  });
}

app.listen(4000, () => {
  console.error("listening on port 4000");
});
