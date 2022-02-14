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
    loadImage: function(color, canvas, x, y, url, w = null, h = null, caption = null, status = null) {
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

            context.fillStyle = color;

            if (caption != null) {
                context.font = "12px Arial";
                context.textAlign = "center";
                context.fillText(caption, target.x + (w/2), target.y+h+10);
            }

            if (status != null) {
                context.font = "bold 14px Arial";
                context.textAlign = "center";
                context.fillText(status, target.x + (w/2), target.y+h+100);
            }
    
        };
        console.log('## loading '+url);
        image.src = url;
    }
}

window.ann = {
    keluhan: {
        draw: function(column, status, inputerCaption, spvjmtcCaption, serviceproviderCaption, regionalCaption, id = 'ann') {
            let path = '../../image/keluhan/';

            let canvas = document.getElementById(id);

            html.canvas.normalize(canvas);

            let color = {
                active: '#000033',
                passive: '#AAAAAA'
            }

            let context = canvas.getContext("2d");
            let c = {
                w: canvas.offsetWidth,
                h: canvas.offsetHeight
            }
            let icon = {
                inputer: { size: 48 },
                spvjmtc: { size: 64 },          
                serviceprovider: { size: 64 },
                regional: { size: 64 }
            }
            console.log('## doing ann @'+c.w+'x'+c.h);

            let x = 100, y = 150, r = 70;

            x = (c.w - (r*9)) /2;
            y = (2*r) + (c.h - (r*6)) /2;

            context.lineWidth = 1;
            context.strokeStyle = color.active;

            context.beginPath();
            context.arc(x, y+r, r, 0, 2 * Math.PI, false);
            context.stroke();

            if (column < 2) context.strokeStyle = color.passive;

            context.beginPath();
            context.moveTo(x + r, y + r);
            context.lineTo(x + (2 * r), y + r);
            context.stroke();

            context.beginPath();
            context.arc(x + (3 * r), y+r, r, 0, 2 * Math.PI, false);
            context.stroke();

            if (column < 3) context.strokeStyle = color.passive;

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

            let ic = color.active;

            media.loadImage(ic, canvas, x - (icon.inputer.size/2), y + 40, path+'inputer.jpg', icon.inputer.size, icon.inputer.size, inputerCaption)
    
            if (column < 2) ic = color.passive;

            media.loadImage(ic, canvas, (x + (3 * r)) - (icon.spvjmtc.size/2), y+30, path+'spv-jmtc.jpg', icon.spvjmtc.size, icon.spvjmtc.size, spvjmtcCaption, status)
    
            if (column < 3) ic = color.passive;

            media.loadImage(ic, canvas, (x + (7 * r)) - (icon.serviceprovider.size/2), y - (2*r) +25, path+'service-provider.jpg', icon.serviceprovider.size, icon.serviceprovider.size, serviceproviderCaption)
    
            media.loadImage(ic, canvas, (x + (7 * r)) - (icon.regional.size/2), y + (2*r) +35, path+'regional.jpg', icon.regional.size, icon.regional.size, regionalCaption)


        }
    },
    claim: {
        draw: function(column, csjmtoCaption, spvjmtoCaption, roCaption, serviceproviderCaption, regionalCaption, id = 'ann') {
            let path = '../../image/claim/';

            let canvas = document.getElementById(id);

            html.canvas.normalize(canvas);

            let color = {
                active: '#000033',
                passive: '#AAAAAA'
            }

            let context = canvas.getContext("2d");
            let c = {
                w: canvas.offsetWidth,
                h: canvas.offsetHeight
            }
            let icon = {
                csjmto: { size: 48 },
                spvjmto: { size: 64 },          
                ro: { size: 64 },          
                serviceprovider: { size: 64 },
                regional: { size: 64 }
            }
            console.log('## doing ann @'+c.w+'x'+c.h);

            let x = 100, y = 150, r = 70;

            x = (c.w - (r*9)) /2;
            y = (2*r) + (c.h - (r*6)) /2;

            context.lineWidth = 1;
            context.strokeStyle = color.active;

            context.beginPath();
            context.arc(x, y+r, r, 0, 2 * Math.PI, false);
            context.stroke();

            if (column < 2) context.strokeStyle = color.passive;

            context.beginPath();
            context.moveTo(x + r, y + r);
            context.lineTo(x + (2 * r), y + r);
            context.stroke();

            context.beginPath();
            context.arc(x + (3 * r), y+r, r, 0, 2 * Math.PI, false);
            context.stroke();

            if (column < 3) context.strokeStyle = color.passive;

            context.beginPath();
            context.moveTo(x + (4 * r), y + r);
            context.lineTo(x + (5 * r), y + r);
            context.stroke();

            context.beginPath();
            context.arc(x + (6 * r), y+r, r, 0, 2 * Math.PI, false);
            context.stroke();

            if (column < 4) context.strokeStyle = color.passive;

            context.beginPath();
            context.arc(x + (10 * r), y - r, r, 0, 2 * Math.PI, false);
            context.stroke();

            context.beginPath();
            context.arc(x + (10 * r), y + (r*3), r, 0, 2 * Math.PI, false);
            context.stroke();

            context.beginPath();
            context.setLineDash([2, 2]);

            context.moveTo(x + (7 * r), y + r);
            context.lineTo(x + (8 * r), y + r);
            context.stroke();

            context.moveTo(x + (8 * r), y - r);
            context.lineTo(x + (9 * r), y - r);
            context.stroke();

            context.moveTo(x + (8 * r), y - r);
            context.lineTo(x + (8 * r), y + (r*3));
            context.stroke();

            context.moveTo(x + (8 * r), y + (r*3));
            context.lineTo(x + (9 * r), y + (r*3));
            context.stroke();

            let ic = color.active;

            media.loadImage(ic, canvas, x - (icon.csjmto.size/2), y + 40, path+'customer.jpg', icon.csjmto.size, icon.csjmto.size, csjmtoCaption)
    
            if (column < 2) ic = color.passive;

            media.loadImage(ic, canvas, (x + (3 * r)) - (icon.spvjmto.size/2), y+30, path+'spv-jmto.jpg', icon.spvjmto.size, icon.spvjmto.size, spvjmtoCaption, status)
    
            if (column < 3) ic = color.passive;

            media.loadImage(ic, canvas, (x + (6 * r)) - (icon.ro.size/2), y+30, path+'ro.jpg', icon.ro.size, icon.ro.size, roCaption, status)
    
            if (column < 4) ic = color.passive;

            media.loadImage(ic, canvas, (x + (10 * r)) - (icon.serviceprovider.size/2), y - (2*r) +25, path+'service-provider.jpg', icon.serviceprovider.size, icon.serviceprovider.size, serviceproviderCaption)
            media.loadImage(ic, canvas, (x + (10 * r)) - (icon.regional.size/2), y + (2*r) +35, path+'regional.jpg', icon.regional.size, icon.regional.size, regionalCaption)


        }
    }
}