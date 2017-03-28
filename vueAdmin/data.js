var http = require('http');
var url = require('url');
var util = require('util');

http.createServer(function (req, res) {
    res.setHeader('Content-Type', 'application/json');
    res.setHeader('Access-Control-Allow-Origin', 'http://localhost:8001');
    res.end(JSON.stringify({"code": 0, "data": {"id": 1}}));
}).listen(8080, function() {
    console.log('listening on localhost:8080');
});