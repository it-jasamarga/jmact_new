console.log('## ann.js by adhi.riady@gmail.com');

window.html = {
    canvas: {
        normalize: function(canvas) {
            let dpi = window.devicePixelRatio;
            let style_height = +getComputedStyle(canvas).getPropertyValue("height").slice(0, -2);
            let style_width = +getComputedStyle(canvas).getPropertyValue("width").slice(0, -2);
            canvas.setAttribute('height', style_height * dpi);
            canvas.setAttribute('width', style_width * dpi);
        }
    }
}

window.media = {
    images: {},
    loadImage: function(canvas, x, y, url, w = null, h = null, caption = null) {
        let image = new Image();
        image.dataset.url = url;
        media.images[url] = { canvas: canvas, x: x, y: y, url, w: w, h: h }
        image.onload = (e) => {
            let image = e.path[0];
            let target = media.images[image.dataset.url];
            console.log('## loaded '+url, image.data)
            let w = target.w == null ? image.width : target.w;
            let h = target.h == null ? image.height : target.h;

            let tempCanvas = document.createElement("canvas");
            tempCanvas.width = w;
            tempCanvas.height = h;
            let tempContext = tempCanvas.getContext("2d");
            tempContext.drawImage(image, 0, 0, w, h);

            let tempImage = tempContext.getImageData(0, 0, w, h);
            let tempData = tempImage.data,
            length = tempData.length;
            for(var i=3; i < length; i+=4) {    // RGBA
                if ((tempData[i-3] == 255) && (tempData[i-2] == 255) && (tempData[i-1] == 255)) {    // each white color
                    tempData[i] = 0;   // set opacity to zero
                }
            }
            tempImage.data = tempData;
            tempContext.putImageData(tempImage, 0, 0);
            
            let context = target.canvas.getContext('2d');
            context.drawImage(tempCanvas, target.x, target.y, w, h );

            if (caption != null) {
                context.font = "12px Arial";
                context.textAlign = "center";
                context.fillText(caption, target.x + (w/2), target.y+h+10);
            }
    
        };
        console.log('## loading '+url);
        image.src = url;
    }
}


window.ann = {
    do: function(pencilCaption, paperCaption, personCaption, roadCaption, id = 'ann') {
        let canvas = document.getElementById(id);

        html.canvas.normalize(canvas);

        let context = canvas.getContext("2d");
        let c = {
            w: canvas.offsetWidth,
            h: canvas.offsetHeight
        }
        let icon = {
            pencil: { size: 48 },
            paper: { size: 64 },          
            man: { size: 48 },
            road: { size: 48 }
        }
        console.log('## doing ann @'+c.w+'x'+c.h);

        let x = 100, y = 150, r = 50;

        context.lineWidth = 1;
        context.strokeStyle = '#000066';

        context.beginPath();
        context.arc(x, y+r, r, 0, 2 * Math.PI, false);
        context.stroke();

        context.beginPath();
        context.moveTo(x + r, y + r);
        context.lineTo(x + (2 * r), y + r);
        context.stroke();

        context.beginPath();
        context.arc(x + (3 * r), y+r, r, 0, 2 * Math.PI, false);
        context.stroke();

        context.beginPath();
        context.arc(x + (7 * r), y - r, r, 0, 2 * Math.PI, false);
        context.stroke();

        context.beginPath();
        context.arc(x + (7 * r), y + (r*3), r, 0, 2 * Math.PI, false);
        context.stroke();

        context.beginPath();
        context.setLineDash([2, 2]);

        context.moveTo(x + (4 * r), y + r);
        context.lineTo(x + (5 * r), y + r);
        context.stroke();

        context.moveTo(x + (5 * r), y - r);
        context.lineTo(x + (6 * r), y - r);
        context.stroke();

        context.moveTo(x + (5 * r), y - r);
        context.lineTo(x + (5 * r), y + (r*3));
        context.stroke();

        context.moveTo(x + (5 * r), y + (r*3));
        context.lineTo(x + (6 * r), y + (r*3));
        context.stroke();

        media.loadImage(canvas, x - (icon.pencil.size/2), y + 16, '/image/pencil-write.jpg', icon.pencil.size, icon.pencil.size, pencilCaption)
 
        media.loadImage(canvas, (x + (3 * r)) - (icon.paper.size/2), y, '/image/paper-sheet.jpg', icon.paper.size, icon.paper.size, paperCaption)
 
        media.loadImage(canvas, (x + (7 * r)) - (icon.man.size/2), y - (2*r) +5, '/image/man.jpg', icon.man.size, icon.man.size, personCaption)
 
        media.loadImage(canvas, (x + (7 * r)) - (icon.man.size/2), y + (2*r) +7, '/image/road.jpg', icon.man.size, icon.man.size, roadCaption)


    }
}