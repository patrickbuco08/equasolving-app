import { User } from '../utilities/auth';
import {io} from "socket.io-client";
(async () => { 
    const socket = io("ws://localhost:3000");
    const user = await User();
    console.log(user);

    // receive a message from the server
    socket.on("hello", (arg) => { 
        console.log(arg) // prints "world"
     });

     //send a message to the server
     socket.emit("howdy", "stranger");

 })();