/*!
* chartjs-test-utils v0.3.1
* https://github.com/chartjs/chartjs-test-utils#readme
 * (c) 2021 chartjs-plugin-annotation Contributors
 * Released under the MIT License
 */
// Code from https://stackoverflow.com/questions/4406864/html-canvas-unit-testing
class Context {
  constructor() {
    this._calls = []; // names/args of recorded calls
    this._initMethods();

    this._fillStyle = null;
    this._font = null;
    this._lineCap = null;
    this._lineDashOffset = null;
    this._lineJoin = null;
    this._lineWidth = null;
    this._strokeStyle = null;
    this._textAlign = null;
    this._textBaseline = null;

    // Define properties here so that we can record each time they are set
    Object.defineProperties(this, {
      fillStyle: {
        get: function() {
          return this._fillStyle;
        },
        set: function(style) {
          this._fillStyle = style;
          this.record('setFillStyle', [style]);
        }
      },
      font: {
        get: function() {
          return this._font;
        },
        set: function(font) {
          this._font = font;
          this.record('setFont', [font]);
        }
      },
      lineCap: {
        get: function() {
          return this._lineCap;
        },
        set: function(cap) {
          this._lineCap = cap;
          this.record('setLineCap', [cap]);
        }
      },
      lineDashOffset: {
        get: function() {
          return this._lineDashOffset;
        },
        set: function(offset) {
          this._lineDashOffset = offset;
          this.record('setLineDashOffset', [offset]);
        }
      },
      lineJoin: {
        get: function() {
          return this._lineJoin;
        },
        set: function(join) {
          this._lineJoin = join;
          this.record('setLineJoin', [join]);
        }
      },
      lineWidth: {
        get: function() {
          return this._lineWidth;
        },
        set: function(width) {
          this._lineWidth = width;
          this.record('setLineWidth', [width]);
        }
      },
      strokeStyle: {
        get: function() {
          return this._strokeStyle;
        },
        set: function(style) {
          this._strokeStyle = style;
          this.record('setStrokeStyle', [style]);
        }
      },
      textAlign: {
        get: function() {
          return this._textAlign;
        },
        set: function(align) {
          this._textAlign = align;
          this.record('setTextAlign', [align]);
        }
      },
      textBaseline: {
        get: function() {
          return this._textBaseline;
        },
        set: function(baseline) {
          this._textBaseline = baseline;
          this.record('setTextBaseline', [baseline]);
        }
      }
    });
  }
  _initMethods() {
    // define methods to test here
    // no way to introspect so we have to do some extra work :(
    var me = this;
    var methods = {
      arc: function() { },
      arcTo: function() { },
      beginPath: function() { },
      bezierCurveTo: function() { },
      clearRect: function() { },
      clip: function() { },
      closePath: function() { },
      fill: function() { },
      fillRect: function() { },
      fillText: function() { },
      strokeText: function() { },
      lineTo: function() { },
      measureText: function(text) {
        // return the number of characters * fixed size
        // Uses fake numbers for the bounding box
        return text ? {
          actualBoundingBoxAscent: 4,
          actualBoundingBoxDescent: 8,
          actualBoundingBoxLeft: 15,
          actualBoundingBoxRight: 25,
          width: text.length * 10
        } : {
          actualBoundingBoxAscent: 0,
          actualBoundingBoxDescent: 0,
          actualBoundingBoxLeft: 0,
          actualBoundingBoxRight: 0,
          width: 0
        };
      },
      moveTo: function() { },
      quadraticCurveTo: function() { },
      rect: function() { },
      restore: function() { },
      rotate: function() { },
      save: function() { },
      setLineDash: function() { },
      stroke: function() { },
      strokeRect: function() { },
      setTransform: function() { },
      translate: function() { },
    };

    Object.keys(methods).forEach(function(name) {
      me[name] = function() {
        me.record(name, arguments);
        return methods[name].apply(me, arguments);
      };
    });
  }
  record(methodName, args) {
    this._calls.push({
      name: methodName,
      args: Array.prototype.slice.call(args)
    });
  }
  getCalls() {
    return this._calls;
  }
  resetCalls() {
    this._calls = [];
  }
}

var pixelmatch_1 = pixelmatch;

const defaultOptions = {
    threshold: 0.1,         // matching threshold (0 to 1); smaller is more sensitive
    includeAA: false,       // whether to skip anti-aliasing detection
    alpha: 0.1,             // opacity of original image in diff ouput
    aaColor: [255, 255, 0], // color of anti-aliased pixels in diff output
    diffColor: [255, 0, 0], // color of different pixels in diff output
    diffColorAlt: null,     // whether to detect dark on light differences between img1 and img2 and set an alternative color to differentiate between the two
    diffMask: false         // draw the diff over a transparent background (a mask)
};

function pixelmatch(img1, img2, output, width, height, options) {

    if (!isPixelData(img1) || !isPixelData(img2) || (output && !isPixelData(output)))
        throw new Error('Image data: Uint8Array, Uint8ClampedArray or Buffer expected.');

    if (img1.length !== img2.length || (output && output.length !== img1.length))
        throw new Error('Image sizes do not match.');

    if (img1.length !== width * height * 4) throw new Error('Image data size does not match width/height.');

    options = Object.assign({}, defaultOptions, options);

    // check if images are identical
    const len = width * height;
    const a32 = new Uint32Array(img1.buffer, img1.byteOffset, len);
    const b32 = new Uint32Array(img2.buffer, img2.byteOffset, len);
    let identical = true;

    for (let i = 0; i < len; i++) {
        if (a32[i] !== b32[i]) { identical = false; break; }
    }
    if (identical) { // fast path if identical
        if (output && !options.diffMask) {
            for (let i = 0; i < len; i++) drawGrayPixel(img1, 4 * i, options.alpha, output);
        }
        return 0;
    }

    // maximum acceptable square distance between two colors;
    // 35215 is the maximum possible value for the YIQ difference metric
    const maxDelta = 35215 * options.threshold * options.threshold;
    let diff = 0;

    // compare each pixel of one image against the other one
    for (let y = 0; y < height; y++) {
        for (let x = 0; x < width; x++) {

            const pos = (y * width + x) * 4;

            // squared YUV distance between colors at this pixel position, negative if the img2 pixel is darker
            const delta = colorDelta(img1, img2, pos, pos);

            // the color difference is above the threshold
            if (Math.abs(delta) > maxDelta) {
                // check it's a real rendering difference or just anti-aliasing
                if (!options.includeAA && (antialiased(img1, x, y, width, height, img2) ||
                                           antialiased(img2, x, y, width, height, img1))) {
                    // one of the pixels is anti-aliasing; draw as yellow and do not count as difference
                    // note that we do not include such pixels in a mask
                    if (output && !options.diffMask) drawPixel(output, pos, ...options.aaColor);

                } else {
                    // found substantial difference not caused by anti-aliasing; draw it as such
                    if (output) {
                        drawPixel(output, pos, ...(delta < 0 && options.diffColorAlt || options.diffColor));
                    }
                    diff++;
                }

            } else if (output) {
                // pixels are similar; draw background as grayscale image blended with white
                if (!options.diffMask) drawGrayPixel(img1, pos, options.alpha, output);
            }
        }
    }

    // return the number of different pixels
    return diff;
}

function isPixelData(arr) {
    // work around instanceof Uint8Array not working properly in some Jest environments
    return ArrayBuffer.isView(arr) && arr.constructor.BYTES_PER_ELEMENT === 1;
}

// check if a pixel is likely a part of anti-aliasing;
// based on "Anti-aliased Pixel and Intensity Slope Detector" paper by V. Vysniauskas, 2009

function antialiased(img, x1, y1, width, height, img2) {
    const x0 = Math.max(x1 - 1, 0);
    const y0 = Math.max(y1 - 1, 0);
    const x2 = Math.min(x1 + 1, width - 1);
    const y2 = Math.min(y1 + 1, height - 1);
    const pos = (y1 * width + x1) * 4;
    let zeroes = x1 === x0 || x1 === x2 || y1 === y0 || y1 === y2 ? 1 : 0;
    let min = 0;
    let max = 0;
    let minX, minY, maxX, maxY;

    // go through 8 adjacent pixels
    for (let x = x0; x <= x2; x++) {
        for (let y = y0; y <= y2; y++) {
            if (x === x1 && y === y1) continue;

            // brightness delta between the center pixel and adjacent one
            const delta = colorDelta(img, img, pos, (y * width + x) * 4, true);

            // count the number of equal, darker and brighter adjacent pixels
            if (delta === 0) {
                zeroes++;
                // if found more than 2 equal siblings, it's definitely not anti-aliasing
                if (zeroes > 2) return false;

            // remember the darkest pixel
            } else if (delta < min) {
                min = delta;
                minX = x;
                minY = y;

            // remember the brightest pixel
            } else if (delta > max) {
                max = delta;
                maxX = x;
                maxY = y;
            }
        }
    }

    // if there are no both darker and brighter pixels among siblings, it's not anti-aliasing
    if (min === 0 || max === 0) return false;

    // if either the darkest or the brightest pixel has 3+ equal siblings in both images
    // (definitely not anti-aliased), this pixel is anti-aliased
    return (hasManySiblings(img, minX, minY, width, height) && hasManySiblings(img2, minX, minY, width, height)) ||
           (hasManySiblings(img, maxX, maxY, width, height) && hasManySiblings(img2, maxX, maxY, width, height));
}

// check if a pixel has 3+ adjacent pixels of the same color.
function hasManySiblings(img, x1, y1, width, height) {
    const x0 = Math.max(x1 - 1, 0);
    const y0 = Math.max(y1 - 1, 0);
    const x2 = Math.min(x1 + 1, width - 1);
    const y2 = Math.min(y1 + 1, height - 1);
    const pos = (y1 * width + x1) * 4;
    let zeroes = x1 === x0 || x1 === x2 || y1 === y0 || y1 === y2 ? 1 : 0;

    // go through 8 adjacent pixels
    for (let x = x0; x <= x2; x++) {
        for (let y = y0; y <= y2; y++) {
            if (x === x1 && y === y1) continue;

            const pos2 = (y * width + x) * 4;
            if (img[pos] === img[pos2] &&
                img[pos + 1] === img[pos2 + 1] &&
                img[pos + 2] === img[pos2 + 2] &&
                img[pos + 3] === img[pos2 + 3]) zeroes++;

            if (zeroes > 2) return true;
        }
    }

    return false;
}

// calculate color difference according to the paper "Measuring perceived color difference
// using YIQ NTSC transmission color space in mobile applications" by Y. Kotsarenko and F. Ramos

function colorDelta(img1, img2, k, m, yOnly) {
    let r1 = img1[k + 0];
    let g1 = img1[k + 1];
    let b1 = img1[k + 2];
    let a1 = img1[k + 3];

    let r2 = img2[m + 0];
    let g2 = img2[m + 1];
    let b2 = img2[m + 2];
    let a2 = img2[m + 3];

    if (a1 === a2 && r1 === r2 && g1 === g2 && b1 === b2) return 0;

    if (a1 < 255) {
        a1 /= 255;
        r1 = blend(r1, a1);
        g1 = blend(g1, a1);
        b1 = blend(b1, a1);
    }

    if (a2 < 255) {
        a2 /= 255;
        r2 = blend(r2, a2);
        g2 = blend(g2, a2);
        b2 = blend(b2, a2);
    }

    const y1 = rgb2y(r1, g1, b1);
    const y2 = rgb2y(r2, g2, b2);
    const y = y1 - y2;

    if (yOnly) return y; // brightness difference only

    const i = rgb2i(r1, g1, b1) - rgb2i(r2, g2, b2);
    const q = rgb2q(r1, g1, b1) - rgb2q(r2, g2, b2);

    const delta = 0.5053 * y * y + 0.299 * i * i + 0.1957 * q * q;

    // encode whether the pixel lightens or darkens in the sign
    return y1 > y2 ? -delta : delta;
}

function rgb2y(r, g, b) { return r * 0.29889531 + g * 0.58662247 + b * 0.11448223; }
function rgb2i(r, g, b) { return r * 0.59597799 - g * 0.27417610 - b * 0.32180189; }
function rgb2q(r, g, b) { return r * 0.21147017 - g * 0.52261711 + b * 0.31114694; }

// blend semi-transparent color with white
function blend(c, a) {
    return 255 + (c - 255) * a;
}

function drawPixel(output, pos, r, g, b) {
    output[pos + 0] = r;
    output[pos + 1] = g;
    output[pos + 2] = b;
    output[pos + 3] = 255;
}

function drawGrayPixel(img, i, alpha, output) {
    const r = img[i + 0];
    const g = img[i + 1];
    const b = img[i + 2];
    const val = blend(rgb2y(r, g, b), alpha * img[i + 3] / 255);
    drawPixel(output, i, val, val, val);
}

const characters = new Image();
// data url for image containing all the characters
characters.src = 'data:image/png;base64,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';

// the data url image size
const imgWidth = 256;
const imgHeight = 256;
// individual characted bounding box
const cellWidth = 17;
const cellHeight = 17;
// char code for [0, 0]
const startIndex = 32;
// number of columns in image
const columns = Math.floor(imgWidth / cellWidth);
// number of rows in image
const rows = Math.floor(imgHeight / cellHeight);
// font height (in pixels)
const fontHeight = 16;
// the font widths by char code, starting at startIndex
const fontWidth = [
  4, 4, 6, 7, 7, 10, 9, 3, 4, 4, 5, 8, 4, 4, 4, 4,
  7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 4, 4, 8, 8, 8, 8,
  13, 9, 9, 9, 9, 8, 8, 10, 9, 4, 7, 9, 8, 11, 9, 10,
  9, 10, 9, 9, 8, 9, 9, 13, 9, 8, 7, 4, 4, 4, 8, 7,
  4, 8, 8, 7, 8, 8, 4, 8, 8, 4, 4, 7, 4, 12, 8, 8,
  8, 8, 5, 6, 4, 8, 7, 11, 8, 7, 7, 5, 3, 5, 8, 10,
  7, 10, 4, 7, 7, 13, 7, 7, 4, 12, 9, 4, 14, 10, 7, 10,
  10, 4, 4, 7, 7, 5, 7, 13, 4, 13, 6, 4, 12, 10, 7, 8,
  4, 4, 7, 7, 7, 7, 3, 7, 4, 10, 5, 7, 8, 4, 10, 7,
  5, 7, 4, 4, 4, 7, 7, 4, 4, 4, 5, 7, 11, 11, 11, 8,
  9, 9, 9, 9, 9, 9, 13, 9, 8, 8, 8, 8, 4, 4, 4, 4,
  9, 9, 10, 10, 10, 10, 10, 8, 10, 9, 9, 9, 9, 8, 9, 8,
  8, 8, 8, 8, 8, 8, 12, 7, 8, 8, 8, 8, 4, 4, 4, 4,
  8, 8, 8, 8, 8, 8, 8, 7, 8, 8, 8, 8, 8, 7, 8, 7
];

// get coordinates and size for one character
function getChar(asciiCode) {
  const index = asciiCode - startIndex;
  const x = Math.min(index % columns, columns - 1);
  const y = Math.min(Math.floor(index / columns), rows - 1);
  return {sx: x * cellWidth, sy: y * cellHeight, w: fontWidth[index], h: fontHeight};
}

function measureText(text) {
  let width = 0;
  if (text && text.charCodeAt) {
    for (let i = 0; i < text.length; ++i) {
      width += fontWidth[Math.min(223, text.charCodeAt(i) - startIndex)];
    }
  }
  return {width};
}

function spriteWrite(text, x, y) {
  if (text && text.charCodeAt) {
    const align = this.textAlign;
    if (align === 'center' || align === 'right') {
      const w = measureText(text).width;
      x -= align === 'center' ? w / 2 : w;
    }
    const base = this.textBaseline;
    switch (base) {
    case 'top':
    case 'hanging':
      y -= fontHeight;
      break;
    case 'middle':
    case 'alphabetic':
    case 'ideaographic':
      y -= fontHeight / 2;
      break;
    }
    for (let i = 0; i < text.length; ++i) {
      const {sx, sy, w, h} = getChar(text.charCodeAt(i));
      this.drawImage(characters, sx, sy, w, h, x, y, w, h);
      x += w;
    }
  }
}

function spritingOn(ctx) {
  if (ctx && !ctx._fillText) {
    ctx._fillText = ctx.fillText;
    ctx._measureText = ctx.measureText;

    ctx.fillText = spriteWrite;
    ctx.measureText = measureText;
  }
}

function spritingOff(ctx) {
  if (ctx && ctx._fillText) {
    ctx.fillText = ctx._fillText;
    ctx.measureText = ctx._measureText;
    delete ctx._fillText;
    delete ctx._measureText;
  }
}

function createCanvas(w, h) {
  var canvas = document.createElement('canvas');
  canvas.width = w;
  canvas.height = h;
  return canvas;
}

function readImageData(url, callback) {
  var image = new Image();

  image.onload = function() {
    var h = image.height;
    var w = image.width;
    var canvas = createCanvas(w, h);
    var ctx = canvas.getContext('2d');
    ctx.drawImage(image, 0, 0, w, h);
    callback(ctx.getImageData(0, 0, w, h));
  };

  image.src = url;
}

/**
 * Injects a new canvas (and div wrapper) and creates the associated Chart instance
 * using the given config. Additional options allow tweaking elements generation.
 * @param {object} config - Chart config.
 * @param {object} options - Chart acquisition options.
 * @param {object} options.canvas - Canvas attributes.
 * @param {object} options.wrapper - Canvas wrapper attributes.
 * @param {boolean} options.useOffscreenCanvas - use an OffscreenCanvas instead of the normal HTMLCanvasElement.
 * @param {boolean} options.useShadowDOM - use shadowDom
 * @param {boolean} options.persistent - If true, the chart will not be released after the spec.
 */
function _acquireChart(config, options) {
  var wrapper = document.createElement('div');
  var canvas = document.createElement('canvas');
  var chart, key;

  config = config || {};
  options = options || {};
  options.canvas = options.canvas || {height: 512, width: 512};
  options.wrapper = options.wrapper || {class: 'chartjs-wrapper'};

  for (key in options.canvas) {
    if (Object.prototype.hasOwnProperty.call(options.canvas, key)) {
      canvas.setAttribute(key, options.canvas[key]);
    }
  }

  for (key in options.wrapper) {
    if (Object.prototype.hasOwnProperty.call(options.wrapper, key)) {
      wrapper.setAttribute(key, options.wrapper[key]);
    }
  }

  // by default, remove chart animation and auto resize
  config.options = config.options || {};
  config.options.animation = config.options.animation === undefined ? false : config.options.animation;
  config.options.responsive = config.options.responsive === undefined ? false : config.options.responsive;
  config.options.locale = config.options.locale || 'en-US';

  if (options.useShadowDOM) {
    if (!wrapper.attachShadow) {
      // If shadowDOM is not supported by the browsers, mark test as 'pending'.
      return pending();
    }
    wrapper.attachShadow({mode: 'open'}).appendChild(canvas);
  } else {
    wrapper.appendChild(canvas);
  }
  window.document.body.appendChild(wrapper);

  try {
    var ctx;
    if (options.useOffscreenCanvas) {
      if (!canvas.transferControlToOffscreen) {
        // If this browser does not support offscreen canvas, mark the test as 'pending', which will skip the
        // test.
        // TODO: switch to skip() once it's implemented (https://github.com/jasmine/jasmine/issues/1709), or
        // remove if all browsers implement `transferControlToOffscreen`
        return pending();
      }
      var offscreenCanvas = canvas.transferControlToOffscreen();
      ctx = offscreenCanvas.getContext('2d');
    } else {
      ctx = canvas.getContext('2d');
    }
    if (options.spriteText) {
      spritingOn(ctx);
    }
    chart = new Chart(ctx, config);
  } catch (e) {
    window.document.body.removeChild(wrapper);
    throw e;
  }

  chart.$test = {
    persistent: options.persistent,
    wrapper: wrapper
  };

  return chart;
}

function _releaseChart(chart) {
  spritingOff(chart.ctx);
  chart.destroy();

  var wrapper = (chart.$test || {}).wrapper;
  if (wrapper && wrapper.parentNode) {
    wrapper.parentNode.removeChild(wrapper);
  }
}

function injectCSS(css) {
  // https://stackoverflow.com/q/3922139
  var head = document.getElementsByTagName('head')[0];
  var style = document.createElement('style');
  style.setAttribute('type', 'text/css');
  if (style.styleSheet) { // IE
    style.styleSheet.cssText = css;
  } else {
    style.appendChild(document.createTextNode(css));
  }
  head.appendChild(style);
}

function waitForResize(chart, callback) {
  var override = chart.resize;
  chart.resize = function() {
    chart.resize = override;
    override.apply(this, arguments);
    callback();
  };
}

function afterEvent(chart, type, callback) {
  var override = chart._eventHandler;
  chart._eventHandler = function(event) {
    override.call(this, event);
    if (event.type === type || (event.native && event.native.type === type)) {
      chart._eventHandler = override;
      // eslint-disable-next-line callback-return
      callback();
    }
  };
}

function _resolveElementPoint(el) {
  var point = {x: 0, y: 0};
  if (el) {
    if (typeof el.getCenterPoint === 'function') {
      point = el.getCenterPoint();
    } else if (el.x !== undefined && el.y !== undefined) {
      point = el;
    }
  }
  return point;
}

async function triggerMouseEvent(chart, type, el) {
  var node = chart.canvas;
  var rect = node.getBoundingClientRect();
  var point = _resolveElementPoint(el);
  var event = new MouseEvent(type, {
    clientX: rect.left + point.x,
    clientY: rect.top + point.y,
    cancelable: true,
    bubbles: true,
    view: window
  });

  var promise = new Promise((resolve) => {
    afterEvent(chart, type, resolve);
  });

  node.dispatchEvent(event);

  await promise;
}

function isObject(value) {
  return Object.prototype.toString.call(value) === '[object Object]';
}

function isArray(value) {
  return Object.prototype.toString.call(value) === '[object Array]';
}

function fmt(val) {
  if (typeof val === 'string') {
    return `"${val}"`;
  }
  if (isArray(val) || isObject(val)) {
    return JSON.stringify(val);
  }
  return `${val}`;
}

function compareArray(actual, expected, path) {
  let ret = true;
  const diff = [];

  if (!isArray(actual)) {
    diff.push(`${path}: Expected ${fmt(actual)} to be an array`);
    ret = false;
    actual = {};
  }

  if (actual.length !== expected.length) {
    diff.push(`${path}.length: Expected ${actual.length} to equal ${expected.length}`);
    ret = false;
  }
  for (let i = 0; i < expected.length; i++) {
    const act = actual[i];
    const exp = expected[i];
    const cmp = compareOption(act, exp, `${path}[${i}]`);
    if (isObject(cmp)) {
      if (!cmp.pass) {
        diff.push(cmp.message);
        ret = false;
      }
    } else if (!cmp) {
      diff.push(`${path}[${i}]: Expected ${fmt(act)} to equal ${fmt(exp)}`);
      ret = false;
    }
  }
  return {
    pass: ret,
    message: diff.join('\n')
  };
}

function compareObject(actual, expected, path = '') {
  let ret = true;
  const diff = [];

  if (!isObject(actual)) {
    diff.push(`${path}: Expected ${fmt(actual)} to be an object`);
    ret = false;
    actual = {};
  }

  if (path !== '') {
    path = path + '.';
  }

  for (const key in expected) {
    if (typeof key === 'string' && key.startsWith('_')) {
      continue;
    }
    if (!Object.prototype.hasOwnProperty.call(expected, key)) {
      continue;
    }
    const act = actual[key];
    const exp = expected[key];
    const cmp = compareOption(act, exp, `${path}${key}`);
    if (isObject(cmp)) {
      if (!cmp.pass) {
        diff.push(cmp.message);
        ret = false;
      }
    } else if (!cmp) {
      diff.push(`${path}${key}: Expected ${fmt(act)} to equal ${fmt(exp)}`);
      ret = false;
    }
  }
  return {
    pass: ret,
    message: diff.join('\n')
  };
}

function compareOption(actual, expected, path) {
  let ret = true;

  if (isObject(expected)) {
    ret = compareObject(actual, expected, path);
  } else if (isArray(expected)) {
    ret = compareArray(actual, expected, path);
  } else {
    ret = actual === expected;
  }
  return ret;
}

function toEqualOptions() {
  return {
    compare(actual, expected) {
      return compareObject(actual, expected);
    }
  };
}

function toPercent(value) {
  return Math.round(value * 10000) / 100;
}

function createImageData(w, h) {
  var canvas = createCanvas(w, h);
  var context = canvas.getContext('2d');
  return context.getImageData(0, 0, w, h);
}

function canvasFromImageData(data) {
  var canvas = createCanvas(data.width, data.height);
  var context = canvas.getContext('2d');
  context.putImageData(data, 0, 0);
  return canvas;
}

function buildPixelMatchPreview(actual, expected, diff, threshold, tolerance, count, description) {
  var ratio = count / (actual.width * actual.height);
  var wrapper = document.createElement('div');
  wrapper.appendChild(document.createTextNode(description));

  wrapper.style.cssText = 'display: flex; overflow-y: auto';

  [
    {data: actual, label: 'Actual'},
    {data: expected, label: 'Expected'},
    {data: diff, label:
			'diff: ' + count + 'px ' +
			'(' + toPercent(ratio) + '%)<br/>' +
			'thr: ' + toPercent(threshold) + '%, ' +
			'tol: ' + toPercent(tolerance) + '%'
    }
  ].forEach(function(values) {
    var item = document.createElement('div');
    item.style.cssText = 'text-align: center; font: 12px monospace; line-height: 1.4; margin: 8px';
    item.innerHTML = '<div style="margin: 8px; height: 32px">' + values.label + '</div>';
    var canvas = canvasFromImageData(values.data);
    canvas.style.cssText = 'border: 1px dashed red';
    item.appendChild(canvas);
    wrapper.appendChild(item);
  });

  wrapper.toString = () => `Fixture test failed:
  Difference: ${count}px / ${toPercent(ratio)}%
  Threshold: ${toPercent(threshold)}%
  Tolerance: ${toPercent(tolerance)}%`;

  return wrapper;
}

function toBeCloseToPixel() {
  return {
    compare: function(actual, expected) {
      var result = false;

      if (!isNaN(actual) && !isNaN(expected)) {
        var diff = Math.abs(actual - expected);
        var A = Math.abs(actual);
        var B = Math.abs(expected);
        var percentDiff = 0.005; // 0.5% diff
        result = (diff <= (A > B ? A : B) * percentDiff) || diff < 2; // 2 pixels is fine
      }

      return {pass: result};
    }
  };
}

function toBeCloseToPoint() {
  function rnd(v) {
    return Math.round(v * 100) / 100;
  }
  return {
    compare: function(actual, expected) {
      return {
        pass: rnd(actual.x) === rnd(expected.x) && rnd(actual.y) === rnd(expected.y)
      };
    }
  };
}

function toEqualOneOf() {
  return {
    compare: function(actual, expecteds) {
      var result = false;
      for (var i = 0, l = expecteds.length; i < l; i++) {
        if (actual === expecteds[i]) {
          result = true;
          break;
        }
      }
      return {
        pass: result
      };
    }
  };
}

function toBeValidChart() {
  return {
    compare: function(actual) {
      var message = null;

      if (!(actual instanceof Chart)) {
        message = 'Expected ' + actual + ' to be an instance of Chart';
      } else if (Object.prototype.toString.call(actual.canvas) !== '[object HTMLCanvasElement]') {
        message = 'Expected canvas to be an instance of HTMLCanvasElement';
      } else if (Object.prototype.toString.call(actual.ctx) !== '[object CanvasRenderingContext2D]') {
        message = 'Expected context to be an instance of CanvasRenderingContext2D';
      } else if (typeof actual.height !== 'number' || !isFinite(actual.height)) {
        message = 'Expected height to be a strict finite number';
      } else if (typeof actual.width !== 'number' || !isFinite(actual.width)) {
        message = 'Expected width to be a strict finite number';
      }

      return {
        message: message ? message : 'Expected ' + actual + ' to be valid chart',
        pass: !message
      };
    }
  };
}

function toBeChartOfSize() {
  return {
    compare: function(actual, expected) {
      var res = toBeValidChart().compare(actual);
      if (!res.pass) {
        return res;
      }

      var message = null;
      var canvas = actual.ctx.canvas;
      var style = getComputedStyle(canvas);
      var pixelRatio = actual.options.devicePixelRatio || window.devicePixelRatio;
      var dh = parseInt(style.height, 10) || 0;
      var dw = parseInt(style.width, 10) || 0;
      var rh = canvas.height;
      var rw = canvas.width;
      var orh = rh / pixelRatio;
      var orw = rw / pixelRatio;

      // sanity checks
      if (actual.height !== orh) {
        message = 'Expected chart height ' + actual.height + ' to be equal to original render height ' + orh;
      } else if (actual.width !== orw) {
        message = 'Expected chart width ' + actual.width + ' to be equal to original render width ' + orw;
      }

      // validity checks
      if (dh !== expected.dh) {
        message = 'Expected display height ' + dh + ' to be equal to ' + expected.dh;
      } else if (dw !== expected.dw) {
        message = 'Expected display width ' + dw + ' to be equal to ' + expected.dw;
      } else if (rh !== expected.rh) {
        message = 'Expected render height ' + rh + ' to be equal to ' + expected.rh;
      } else if (rw !== expected.rw) {
        message = 'Expected render width ' + rw + ' to be equal to ' + expected.rw;
      }

      return {
        message: message ? message : 'Expected ' + actual + ' to be a chart of size ' + expected,
        pass: !message
      };
    }
  };
}

function toEqualImageData() {
  return {
    compare: function(actual, expected, opts) {
      var message = null;
      var debug = opts.debug || false;
      var tolerance = opts.tolerance === undefined ? 0.001 : opts.tolerance;
      var threshold = opts.threshold === undefined ? 0.1 : opts.threshold;
      var ctx, idata, ddata, w, h, aw, ah, count, ratio;

      if (actual instanceof Chart) {
        ctx = actual.ctx;
      } else if (actual instanceof HTMLCanvasElement) {
        ctx = actual.getContext('2d');
      } else if (actual instanceof CanvasRenderingContext2D) {
        ctx = actual;
      }

      if (ctx) {
        h = expected.height;
        w = expected.width;
        aw = ctx.canvas.width;
        ah = ctx.canvas.height;
        idata = ctx.getImageData(0, 0, aw, ah);
        ddata = createImageData(w, h);
        if (aw === w && ah === h) {
          count = pixelmatch_1(idata.data, expected.data, ddata.data, w, h, {threshold: threshold});
        } else {
          count = Math.abs(aw * ah - w * h);
        }
        ratio = count / (w * h);

        if ((ratio > tolerance) || debug) {
          message = buildPixelMatchPreview(idata, expected, ddata, threshold, tolerance, count, opts.description);
        }
      } else {
        message = 'Input value is not a valid image source.';
      }

      return {
        message: message,
        pass: !message
      };
    }
  };
}

var matchers = {
  toBeCloseToPixel,
  toBeCloseToPoint,
  toEqualOneOf,
  toBeValidChart,
  toBeChartOfSize,
  toEqualImageData,
  toEqualOptions
};

function readFile(url, callback) {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState === 4) {
      return callback(request.responseText);
    }
  };

  request.open('GET', url, false);
  request.send(null);
}

function loadConfig(url, callback) {
  var regex = /\.(json|js)$/i;
  var matches = url.match(regex);
  var type = matches ? matches[1] : 'json';
  var cfg = null;

  readFile(url, function(content) {
    switch (type) {
    case 'js':
      cfg = new Function('"use strict"; var module = {};' + content + '; return module.exports || fixture;')();
      break;
    case 'json':
      cfg = JSON.parse(content);
      break;
    }

    callback(cfg);
  });
}

function specFromFixture(description, inputs) {
  var input = inputs.js || inputs.json;
  it(input, function(done) {
    loadConfig(input, function(json) {
      var descr = json.description || (json.description = description);

      var config = json.config;
      var options = config.options || (config.options = {});

      // plugins are disabled by default, except if the path contains 'plugin' or there are instance plugins
      if (input.indexOf('plugin') === -1 && config.plugins === undefined) {
        options.plugins = options.plugins || false;
      }

      var chart = _acquireChart(config, json.options);
      const _done = () => {
        if (!inputs.png) {
          fail(descr + '\r\nMissing PNG comparison file for ' + input);
          done();
        }

        readImageData(inputs.png, function(expected) {
          expect(chart).toEqualImageData(expected, json);
          _releaseChart(chart);
          done();
        });
      };
      const run = json.options && json.options.run;
      if (typeof run === 'function') {
        Promise.resolve(run(chart)).finally(_done);
      } else {
        _done();
      }
    });
  });
}

function specsFromFixtures(path) {
  var regex = new RegExp('(^/base/test/fixtures/' + path + '.+)\\.(png|json|js)');
  var inputs = {};

  Object.keys(__karma__.files || {}).forEach(function(file) {
    var matches = file.match(regex);
    var name = matches && matches[1];
    var type = matches && matches[2];

    if (name && type) {
      inputs[name] = inputs[name] || {};
      inputs[name][type] = file;
    }
  });

  return function() {
    Object.keys(inputs).forEach(function(key) {
      specFromFixture(key, inputs[key]);
    });
  };
}

// Keep track of all acquired charts to automatically release them after each specs
var charts = {};

/**
 * Injects a new canvas (and div wrapper) and creates the associated Chart instance
 * using the given config. Additional options allow tweaking elements generation.
 * @param {object} config - Chart config.
 * @param {object} options - Chart acquisition options.
 * @param {object} options.canvas - Canvas attributes.
 * @param {object} options.wrapper - Canvas wrapper attributes.
 * @param {boolean} options.useOffscreenCanvas - use an OffscreenCanvas instead of the normal HTMLCanvasElement.
 * @param {boolean} options.useShadowDOM - use shadowDom
 * @param {boolean} options.persistent - If true, the chart will not be released after the spec.
 */
function acquireChart(config, options) {
  var chart = _acquireChart(config, options);
  charts[chart.id] = chart;
  return chart;
}

function releaseChart(chart) {
  _releaseChart(chart);
  delete charts[chart.id];
}

function createMockContext() {
  return new Context();
}

function injectWrapperCSS() {
  // some style initialization to limit differences between browsers across different platforms.
  injectCSS(
    '.chartjs-wrapper, .chartjs-wrapper canvas {' +
		'border: 0;' +
		'margin: 0;' +
		'padding: 0;' +
		'}' +
		'.chartjs-wrapper {' +
		'position: absolute' +
		'}');
}

function addMatchers() {
  jasmine.addMatchers(matchers);
}

function releaseCharts() {
  Object.keys(charts).forEach(function(id) {
    var chart = charts[id];
    if (!(chart.$test || {}).persistent) {
      _releaseChart(chart);
    }
  });
}

export { acquireChart, addMatchers, afterEvent, createMockContext, injectWrapperCSS, releaseChart, releaseCharts, specsFromFixtures, triggerMouseEvent, waitForResize };
