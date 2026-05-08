const express = require("express");
const http = require("http");
const { Server } = require("socket.io");


const app = express();


const server = http.createServer(app);


const io = new Server(server, {
    cors: {
        origin: "*"
    }
});


io.on("connection", (socket) => {

    console.log("User connected");


    socket.on("join_room", (roomId) => {

        socket.join(roomId);

        console.log("Joined room:", roomId);
    });


    socket.on("send_message", (data) => {

        socket.to(data.roomId).emit("receive_message", {
            roomId: data.roomId
        });

    });


    socket.on("disconnect", () => {

        console.log("User disconnected");
    });

});


server.listen(3000, () => {

    console.log("WebSocket server running on port 3000");
});