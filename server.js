const express = require('express');
const app = express();
const request = require('request');
const fireBaseUrl = 'https://watch-yo-weight.firebaseio.com/weights.json';

app.get('/', (req, res) => {
  res.send('Can I help you?');
});

app.get('/weights', (req, res) => {
    request(fireBaseUrl, (error, response, body) => {
        if (error) {
            console.log('Error Encountered accesing fireBaseUrl.')
            console.error(error);
        }

        res.send(body);
    });
});

app.listen(3000, () => {
  console.log('Example app listening on port 3000!')
});