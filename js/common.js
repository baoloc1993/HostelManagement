function checkRoomStatus(room) {
    if (room === undefined) return 0;
    var currentTime = new Date().getTime();
    //0 = available
    //1 = pending
    //2 = occupied
    if (room.end_date > 0 && (room.end_date < currentTime)) return 0;
    if (room.start_date === 0 ) return 0;
    if (room.start_date > currentTime ) return 1;
    else return 2;
}

function resize_image(file){
    
    // Create an image
    var img = document.createElement("img");
    // Create a file reader
    var reader = new FileReader();
    // Set the image once loaded into file reader
    reader.onload = function(e) {
        img.src = e.target.result;
        var dataurl = undefined;
        while (dataurl !== undefined && dataurl !== 'data;,'){
            var canvas = document.createElement("canvas");
            //var canvas = $("<canvas>", {"id":"testing"})[0];
            var ctx = canvas.getContext("2d");
            ctx.drawImage(img, 10,10);
    
            var MAX_WIDTH = 400;
            var MAX_HEIGHT = 400;
            var width = img.width;
            var height = img.height;
    
            if (width > height) {
                if (width > MAX_WIDTH) {
                    height *= MAX_WIDTH / width;
                    width = MAX_WIDTH;
                }
            } else {
                if (height > MAX_HEIGHT) {
                    width *= MAX_HEIGHT / height;
                    height = MAX_HEIGHT;
                }
            }
            canvas.width = width;
            canvas.height = height;
            var ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0, width, height);
    
            var dataurl = canvas.toDataURL("image/png");
        }
    }
    // Load files into file reader
    reader.onloadend = function(e){
        result = reader.url;
    }
    reader.readAsDataURL(file);
    
    return result;
    
}