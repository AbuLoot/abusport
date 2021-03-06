var app =require('express')();
var http=require('http').Server(app);
var io=require('socket.io')(http);
app.get('/',function(req,res){
   res.sendFile(__dirname+'/index.html');
})
io.on('connection',function(socket){
   console.log('one user connected :'+socket.id);
   socket.on('message',function(data){
        // io.emit('message',{message:data});
        console.log(data);
        var sockets=io.sockets.sockets;
	sockets.forEach(function(sock){
          if(sock.id!=socket.id){
		sock.emit('message',{message:data});
         	}
        })
    })
   socket.on('disconnect',function(){
   console.log('One user disconnected'+socket.id); 
 })
})
http.listen(3000,function(){
  console.log('server listening on port 3000');
})
