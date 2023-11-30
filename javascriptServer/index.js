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

const userkey = "Yuin6F565gvyb5g8";
const UserAPIKey = "Yuin6F565gvyb5g8";
const UserDrugsAPIKey = "Yuin6F565gvyb5g8";
const DrugsByUserAPIKey = "Yuin6F565gvyb5g8";

// Generate a random 6-digit verification code
const generateVerificationCode = () => {
  return Math.floor(10000 + Math.random() * 90000);
};

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

// Get all drugs from the database
app.get("/Apis/drugs", (req, res) => {
  const sql = "SELECT * FROM drugs";
  conn.query(sql, (err, result) => {
    if (err) {
      console.error(err);
      res.status(500).json({ error: "Internal Server Error" });
    } else {
      res.json(result);
    }
  });
});

// Get drug information by ID
app.get("/Apis/drugs/:id", (req, res) => {
  const drugId = req.params.id;
  const sql = `SELECT * FROM drugs WHERE id = ${drugId}`;
  conn.query(sql, (err, result) => {
    if (err) {
      console.error(err);
      res.status(500).json({ error: "Internal Server Error" });
    } else {
      if (result.length === 0) {
        res.status(404).json({ error: "Drug not found" });
      } else {
        res.json(result[0]);
      }
    }
  });
});

// Get drugs by category/subcategory
app.get("/Apis/drugs/category", (req, res) => {
  const category = req.params.category;
  const sql = `SELECT * FROM drugs WHERE category = '${category}'`;
  conn.query(sql, (err, result) => {
    if (err) {
      console.error(err);
      res.status(500).json({ error: "Internal Server Error" });
    } else {
      res.json(result);
    }
  });
});

// Get drugs by user (assuming the user information is stored in req.user)
app.get("/Apis/drugs/user", authenticateAPIToken, (req, res) => {
  const userId = req.user.userId; // Assuming the user ID is in the token payload
  const sql = `SELECT * FROM drugs WHERE userId = ${userId}`;
  conn.query(sql, (err, result) => {
    if (err) {
      console.error(err);
      res.status(500).json({ error: "Internal Server Error" });
    } else {
      res.json(result);
    }
  });
});

app.post("/APISub/:apiName/:username", (req, res) => {
  const { apiName, username } = req.params;
  console.log(apiName, username);

  var token;
  if (apiName === "UserAPI") {
    // Assuming UserAPIKey is defined somewhere
    token = jwt.sign({ username: username }, UserAPIKey, {
      expiresIn: "1h",
    });
  } else if (apiName === "UserDrugsAPI") {
    token = jwt.sign({ username: username }, UserDrugsAPIKey, {
      expiresIn: "1h",
    });
  } else if (apiName === "DrugsByUserAPI") {
    // Assuming DrugsByUserAPIKey is defined somewhere
    token = jwt.sign({ username: username }, DrugsByUserAPIKey, {
      expiresIn: "1h",
    });
  }

  res.send({ token: token });
});

function authenticateAPIToken(req, res, next) {
  const token = req.header("Authorization");
  const api = req.params.apiName; // Correctly extracting apiName
  console.log(api, token);

  if (!token) return res.send({ message: "Unauthorized" });

  if (api === "UserAPI") {
    jwt.verify(token, UserAPIKey, (err, user) => {
      if (err) return res.send({ proceed: false });
      req.user = user;
      next();
    });
  } else if (api === "UserDrugsAPI") {
    jwt.verify(token, UserDrugsAPIKey, (err, user) => {
      if (err) {
        res.send({ proceed: false });
        return console.error(false);
      }
      req.user = user;
      next();
    });
  } else {
    jwt.verify(token, DrugsByUserAPIKey, (err, user) => {
      if (err) {
        return res.send({ proceed: false });
      }
      req.user = user;
      next();
    });
  }
}

app.get("/SignIn", (req, res) => {
  fs.readFile("../javascriptclient/SignIn.html", (err, result) => {
    if (err) {
      console.error(err);
    } else {
      res.send(result.toString());
    }
  });
});

app.get("/APIAuth/:apiname", authenticateAPIToken, (req, res) => {
  res.send({ proceed: true });
});

app.get("/UserAPI", (req, res) => {
  let file;
  fs.readFile("../javascriptClient/UserAPI.html", (err, result) => {
    if (err) {
      console.log(err);
    } else {
      file = result.toString();
      res.send(file);
    }
  });
});

app.get("/UserDrugsAPI", (req, res) => {
  let file;
  fs.readFile("../javascriptClient/UserDrugsAPI.html", (err, result) => {
    if (err) {
      console.log(err);
    } else {
      file = result.toString();
      res.send(file);
    }
  });
});

app.get("/Home", (req, res) => {
  let file;
  fs.readFile("../javascriptClient/Home.html", (err, result) => {
    if (err) {
      console.log(err);
    } else {
      file = result.toString();
      res.send(file);
    }
  });
});

app.get("/DrugsAPI", (req, res) => {
  let file;
  fs.readFile("../javascriptClient/DrugsAPI.html", (err, result) => {
    if (err) {
      console.log(err);
    } else {
      file = result.toString();
      res.send(file);
    }
  });
});

app.get("/DrugsByUserAPI", (req, res) => {
  let file;
  fs.readFile("../javascriptClient/DrugsByUserAPI.html", (err, result) => {
    if (err) {
      console.log(err);
    } else {
      file = result.toString();
      res.send(file);
    }
  });
});

app.get(
  "/UserDrugs/:apiname/:type/:query",
  authenticateAPIToken,
  (req, res) => {
    console.log("reached");
    const { type, query } = req.params;
    var sql = `SELECT * FROM PRESCRIPTION WHERE ${type}='${query}' `;

    conn.query(sql, (err, result) => {
      if (err) {
        console.error(err);
        res.send({ er: err, proceed: false });
      } else {
        console.log(result);
        res.send({ result: result, proceed: true });
      }
    });
  }
);

app.get(
  "/Drugs/:type/:query",
  (req, res) => {
    console.log("reached");
    const { type, query } = req.params;
    var sql = `SELECT * FROM DRUGS WHERE ${type}='${query}' `;

    conn.query(sql, (err, result) => {
      if (err) {
        console.error(err);
        res.send({ er: err, proceed: false });
      } else {
        console.log(result);
        res.send({ result: result, proceed: true });
      }
    });
  }
);

app.get("/AllDrugs", (req, res) => {
  
  var sql = `SELECT * FROM DRUGS`;

  conn.query(sql, (err, result) => {
    if (err) {
      console.error(err);
      res.send({ er: err, proceed: false });
    } else {
      console.log(result);
      res.send({ result: result, proceed: true });
    }
  });
});

app.get("/Patients/:type/:query", (req, res) => {
  console.log("reached");
  const { type, query } = req.params;
  var sql = `SELECT * FROM Patients WHERE ${type}='${query}' `;

  conn.query(sql, (err, result) => {
    if (err) {
      console.error(err);
      res.send({ er: err, proceed: false });
    } else {
      console.log(result);
      res.send({ result: result, proceed: true });
    }
  });
});

app.get("/AllUsers", (req, res) => {
  var sql = `SELECT * FROM Patients`;

  conn.query(sql, (err, result) => {
    if (err) {
      console.error(err);
      res.send({ er: err, proceed: false });
    } else {
      console.log(result);
      res.send({ result: result, proceed: true });
    }
  });
});

app.get("/DrugsByUser/:apiName/:id", authenticateAPIToken, (req, res) => {
  const value = req.params.id;
  console.log("Reached", value);
  var sql = `SELECT * FROM PRESCRIPTION WHERE PatientID='${value}' `;
  conn.query(sql, (err, result) => {
    if (err) {
      console.error(err);
      res.send({ err: err, proceed: false });
    } else {
      console.log(result);
      res.send({ result: result, proceed: true });
    }
  });
});

app.get("/value", (req, res) => {});

app.listen(4000, () => {
  console.error("listening on port 4000");
});
