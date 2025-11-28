var server = require('ws').Server;
var s = new server({ port: 30000 });

s.on('connection', function(ws) {
    console.log('Listening to port 30000')
    ws.on('message', function(message){
        console.log("Received: "+message);
        
        if(message=="hello"){
            ws.send('Server: Hey there!');
        }
    });
});