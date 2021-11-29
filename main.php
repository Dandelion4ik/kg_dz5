<html lang="eng">

<body>
<canvas width="1000" height="1000" id="dz5">
</canvas>
<script>
    let canvas = document.getElementById("dz5");
    let ctx = canvas.getContext("2d");
    let x = [];
    let y = [];
    let str = [];
    let flag = false;
    let count = 0;

    function line(x0, y0, x1, y1, color) {
        ctx.fillStyle = color;
        let dy = Math.abs(y1 - y0);
        let dx = Math.abs(x1 - x0);
        let d_max = Math.max(dx, dy);
        let d_min = Math.min(dx, dy);
        let x_dir = 1;
        if (x1 < x0)
            x_dir = -1;
        let y_dir = 1;
        if (y1 < y0)
            y_dir = -1;
        let eps = 0;
        let s = 1;
        let k = 2 * d_min;
        if (dy <= dx) {
            let y = y0;
            for (let x = x0; x * x_dir <= x1 * x_dir; x += x_dir) {
                ctx.fillRect(x * s, y * s, s, s);
                eps = eps + k;
                if (eps > d_max) {
                    y += y_dir;
                    eps = eps - 2 * d_max;
                }
            }
        } else {
            let x = x0;
            for (let y = y0; y * y_dir <= y1 * y_dir; y += y_dir) {
                ctx.fillRect(x * s, y * s, s, s);
                eps = eps + k;
                if (eps > d_max) {
                    x += x_dir;
                    eps = eps - 2 * d_max;
                }
            }
        }
    }

    function fill_area(x, y) {
        let arr = [];
        let point = [x, y];
        arr.push(point);
        while (arr.length !== 0) {
            let newx;
            let newy;
            let newpoint;
            point = arr.pop();
            if (ctx.getImageData(point[0], point[1], 1, 1).data[3] !== 255)
                ctx.fillRect(point[0], point[1], 1, 1);
            if (ctx.getImageData(point[0] + 1, point[1], 1, 1).data[3] !== 255) {
                newx = point[0] + 1;
                newy = point[1];
                newpoint = [newx, newy];
                arr.push(newpoint);
            }
            if (ctx.getImageData(point[0] - 1, point[1], 1, 1).data[3] !== 255) {
                newx = point[0] - 1;
                newy = point[1];
                newpoint = [newx, newy]
                arr.push(newpoint);
            }
            if (ctx.getImageData(point[0], point[1] + 1, 1, 1).data[3] !== 255) {
                newx = point[0];
                newy = point[1] + 1;
                newpoint = [newx, newy];
                arr.push(newpoint);
            }
            if (ctx.getImageData(point[0], point[1] - 1, 1, 1).data[3] !== 255) {
                newx = point[0];
                newy = point[1] - 1;
                newpoint = [newx, newy];
                arr.push(newpoint);
            }

        }
    }

    canvas.addEventListener("click", function (event) {
        if (!flag) {
            x.push(event.offsetX);
            y.push(event.offsetY);
            if (count >= 1)
                line(x[count - 1], y[count - 1], x[count], y[count], "#000000");
            count++;
        } else {
            ctx.fillStyle = "#fff200";
            fill_area(event.offsetX, event.offsetY);
            ctx.fillStyle = "#000000";
        }
    });
    document.addEventListener("keypress", function () {
        flag = true;
        x.push(x[0]);
        y.push(y[0]);
        line(x[count - 1], y[count - 1], x[0], y[0]);
    });
</script>
</body>

</html>