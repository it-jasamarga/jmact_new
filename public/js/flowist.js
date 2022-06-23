window.debug = function(...params) {
    setTimeout(console.log.bind(console, '##', ...params));
}

debug('flowist.js —adhi.riady@gmail.com');

class Flowist {
    constructor(id, rows, columns, padding = 0) {
        let self = this;
        this.parameters = {
            id: id,
            rows: rows,
            columns: columns,
            padding: padding
        };

        this.canvas = document.getElementById(this.parameters.id);
        this.width = this.canvas.clientWidth - (this.parameters.padding*2);
        this.height = this.canvas.clientHeight - (this.parameters.padding*2);
        this.column = { width: this.width / this.parameters.columns };
        this.row = { height: this.height / this.parameters.rows };

        this.context = this.canvas.getContext("2d");

        // normalize
        this.dpi = window.devicePixelRatio;
        this.style = {
            height: +getComputedStyle(this.canvas).getPropertyValue("height").slice(0, -2),
            width: +getComputedStyle(this.canvas).getPropertyValue("width").slice(0, -2)
        };
        this.canvas.setAttribute('height', this.style.height * this.dpi);
        this.canvas.setAttribute('width', this.style.width * this.dpi);

        this.assets = {
            errors: {},
            queue: [],
            callback: null,
            last: null,
            resources: [],

            load: function(urls, callback = null) {
                self.assets.queue = urls;
                self.assets.callback = callback;
                self.assets.last = null;
                self.assets.loading();
            },

            loading: function() {
                if (self.assets.queue.length > 0) {
                    let url = self.assets.queue.shift();
                    if (self.assets.queue.length == 0) self.assets.last = url;
                    let matches = url.match(/([^/]+)\.[a-z]+$/);
                    let id = matches ? matches[1] : url;
                    self.assets.resources[id] = new Image();
                    self.assets.resources[id].dataset.url = url;
                    self.assets.resources[id].onload =  (e) => {
                        let image = e.path[0];
                        let url = image.dataset.url;
                        let matches = url.match(/([^/]+)\.[a-z]+$/);
                        let id = matches ? matches[1] : url;
                        debug('Resource #'+id+' loaded');
                        if (url != self.assets.last)
                            self.assets.loading();
                        else if (typeof self.assets.callback === 'function') self.assets.callback();
                    }
                    self.assets.resources[id].onerror =  (e) => {
                        let image = e.path[0];
                        let url = image.dataset.url;
                        let matches = url.match(/([^/]+)\.[a-z]+$/);
                        let id = matches ? matches[1] : url;
                        self.assets.resources[id] = null;
                        debug('Error loading', {url});
                        if (url != self.assets.last)
                            self.assets.loading();
                        else if (typeof self.assets.callback === 'function') self.assets.callback();
                    }
                    debug('Loading #'+id, url);
                    self.assets.resources[id].src = url;
                }
            }
        }

        this.draw = {
            var: {
                x: 0,
                y: 0,
                thick: 1,
                color: '#000000',
                font: '12px Arial',
                align: 'center'
            },
            adjust: function(x, y) {
                self.draw.var.x += x;
                self.draw.var.y += y;
            },
            color: function(color = '#000000') {
                self.draw.var.color = color;
            },
            dash: function(length1 = 2, length2 = 2) {
                if (self.context.setLineDash !== undefined) {
                    self.context.setLineDash([length1, length2]);
                }
                if (self.context.mozDash !== undefined) {
                    self.context.mozDash = [length1, length2];
                }
            },
            thickness: function(thickness = 1) {
                self.draw.var.thick = thickness;
            },
            font: function(font = '12px Arial') {
                self.draw.var.font = font;
            },
            align: function(align = 'center') {
                self.draw.var.align = align;
            },
            dot: function(filled = true) {
                self.context.beginPath();
                if (self.draw.var.thick > 1) {
                    self.context.arc(self.draw.var.x, self.draw.var.y, self.draw.var.thick, 0, 2 * Math.PI, true);
                    if (filled) {
                        self.context.fillStyle = self.draw.var.color;
                        self.context.fill();
                    } else {
                        self.context.strokeStyle = self.draw.var.color;
                        self.context.stroke();
                    }
                } else if (self.draw.var.thick == 1) {
                    self.context.strokeStyle = self.draw.var.color;
                    self.context.fillRect(self.draw.var.x, self.draw.var.y, self.draw.var.thick, self.draw.var.thick);
                }
            },
            line: function(x1, y1, x2, y2) {
                self.context.strokeStyle = self.draw.var.color;
                self.context.lineWidth = self.draw.var.thick;
                self.context.beginPath();
                self.context.moveTo(x1, y1);
                self.context.lineTo(x2, y2);
                self.context.stroke();
            },
            text: function(text) {
                self.context.beginPath();
                self.context.fillStyle = self.draw.var.color;
                self.context.font = self.draw.var.font;
                self.context.textAlign = self.draw.var.align;
                self.context.fillText(text, self.draw.var.x, self.draw.var.y);
            },
            resource: function(id, width = 0, height = 0, caption = null, caption_color = '#000000', caption_adjustment = 25) {
                if ((typeof self.assets.resources[id] != 'undefined') && (self.assets.resources[id] != null)) {
                    let w = width > 0 ? width : self.assets.resources[id].width;
                    let h = height > 0 ? height : self.assets.resources[id].height;
                    debug('Draw Resource #'+id);//, {width:width, height:height, w:w, h:h});
                    self.context.drawImage(self.assets.resources[id], self.draw.var.x - (w/2), self.draw.var.y - (h/2), w, h);
                    if (caption != null) {
                        self.context.fillStyle = caption_color;
                        self.context.font = self.draw.var.font;
                        self.context.textAlign = self.draw.var.align;
                        self.context.fillText(caption, self.draw.var.x, self.draw.var.y + (h/2) +caption_adjustment);
                    }
                }
            }
        }

        this.grid = {
            move: {
                cell: function(row, column, row_position = 0, column_position = 0) {
                    let x = ((column-1) * self.column.width);
                    if (column_position == 0) x += (self.column.width/2);
                    if (column_position == 1) x += self.column.width;
                    let y = ((row-1) * self.row.height);
                    if (row_position == 0) y += (self.row.height/2);
                    if (row_position == 1) y += self.row.height;
                    x += self.parameters.padding;
                    y += self.parameters.padding;
                    self.context.moveTo(x, y);
                    self.draw.var.x = x;
                    self.draw.var.y = y;
                    return {x, y};
                }
            },
            lineto: {
                cell: function(row, column, row_position = 0, column_position = 0, x_adjustment = 0, y_adjustment = 0) {
                    let x = ((column-1) * self.column.width);
                    if (column_position == 0) x += (self.column.width/2);
                    if (column_position == 1) x += self.column.width;
                    let y = ((row-1) * self.row.height);
                    if (row_position == 0) y += (self.row.height/2);
                    if (row_position == 1) y += self.row.height;
                    x += self.parameters.padding +x_adjustment;
                    y += self.parameters.padding +y_adjustment;
                    self.draw.line(self.draw.var.x, self.draw.var.y, x, y);
                    self.context.moveTo(x, y);
                    self.draw.var.x = x;
                    self.draw.var.y = y;
                    return {x, y};
                }
            },
            draw: function(color = '#DDDDDD') {
                self.draw.thickness(1);
                self.draw.color(color);
                let xs = [];
                let ys = [];
                for (var r=2; r<=self.parameters.rows; r++) {
                    for (var c=2; c<=self.parameters.columns; c++) {
                        var {x, y} = self.grid.move.cell(r, c, -1, -1);
                        if (! xs.includes(x)) xs.push(x);
                        if (! ys.includes(y)) ys.push(y);
                    }
                };
                // debug({xs}, {ys});
                self.draw.dash();
                xs.forEach(x => {
                    self.draw.line(x, 0, x, self.height);
                });
                ys.forEach(y => {
                    self.draw.line(0, y, self.width, y);
                });
                self.draw.dash(0, 0);
                self.context.strokeStyle = self.draw.var.color;
                self.context.lineWidth = self.draw.var.thick;
                for(var i=0; i<self.parameters.padding; i++) {
                    self.context.strokeRect(i, i, self.canvas.clientWidth - (i*2), self.canvas.clientHeight - (i*2));
                }

                debug({self});
            }
        }

    }
}
