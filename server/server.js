const WebSocket = require("ws");

const wss = new WebSocket.Server({
    port: 8082
});

wss.on("connection", (ws) => {
    //initial connection
    console.log('Client has connected');

    //receive message
    ws.on("message", (data) => {
        console.log('client has new message', JSON.parse(data))
        const parsedData = JSON.parse(data)

        ws.send(JSON.stringify(parsedData));
        ws.send(JSON.stringify({
            id: 1,
            user: 'Patrick Demillo Buco from Server'
        }));
    })


    //closes the tab/page
    ws.on("close", () => {
        console.log('client has disconnected');
    })

});