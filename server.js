const express = require('express');
const app = express();
const request = require('request');
require('dotenv').config();
const firebaseUrl = process.env.FIREBASE_URL;

app.get('/', (req, res) => {
    res.send('Can I help you?');
});

app.get('/weights', (req, res) => {
    request(firebaseUrl, (error, response, body) => {
        res.json(body);
    });
});

app.listen(3000, () => {
  console.log('Example app listening on port 3000!')
});