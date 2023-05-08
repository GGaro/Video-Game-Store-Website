<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Snake Game</title>
    <style>
        body {
            background-color: black;
        }

        #gameCanvas {
            margin: auto;
            display: block;
            border: 1px solid white;
        }

        .button-container {
            position: absolute;
            bottom: 50px;
            display: flex;
            justify-content: center;
            width: 90%;
        }

        .button {
            background-color: black;
            color: gold;
            border-radius: 20px;
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: gold;
            color: black;
        }
    </style>
</head>

<body>

    <canvas id="gameCanvas" width="400" height="400"></canvas>
    <div class="button-container" >

        <button class="button" onclick="window.location.href = 'easteregg.php';">Play Again</button>
        <button class="button" onclick="window.location.href = 'index.php';">Go back to index</button>
    </div>

    <script>
        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');

        const CELL_SIZE = 10;
        const CANVAS_WIDTH = 400;
        const CANVAS_HEIGHT = 400;
        const APPLE_COLOR = 'red';
        const SNAKE_COLOR = 'green';

        let snake = [{ x: 50, y: 50 }];
        let apple = { x: 0, y: 0 };
        let score = 0;
        let direction = 'right';
        let gameover = false;

        function generateApple() {
            apple.x = Math.floor(Math.random() * (CANVAS_WIDTH / CELL_SIZE)) * CELL_SIZE;
            apple.y = Math.floor(Math.random() * (CANVAS_HEIGHT / CELL_SIZE)) * CELL_SIZE;
        }

        function draw() {
            ctx.clearRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);

            ctx.fillStyle = SNAKE_COLOR;
            for (let i = 0; i < snake.length; i++) {
                ctx.fillRect(snake[i].x, snake[i].y, CELL_SIZE, CELL_SIZE);
            }

            ctx.fillStyle = APPLE_COLOR;
            ctx.fillRect(apple.x, apple.y, CELL_SIZE, CELL_SIZE);

            ctx.fillStyle = 'white';
            ctx.font = 'bold 24px cursive';
            ctx.fillText('Score: ' + score, 10, 30);
        }

        function move() {
            let head = { x: snake[0].x, y: snake[0].y };
            switch (direction) {
                case 'up':
                    head.y -= CELL_SIZE;
                    break;
                case 'down':
                    head.y += CELL_SIZE;
                    break;
                case 'left':
                    head.x -= CELL_SIZE;
                    break;
                case 'right':
                    head.x += CELL_SIZE;
                    break;
            }

            if (head.x < 0 || head.x >= CANVAS_WIDTH || head.y < 0 || head.y >= CANVAS_HEIGHT) {
                gameover = true;
                return;
            }
            for (let i = 1; i < snake.length; i++) {
                if (head.x == snake[i].x && head.y == snake[i].y) {
                    gameover = true;
                    return;
                }
            }

            snake.unshift(head);

            if (head.x == apple.x && head.y == apple.y) {
                score++;
                generateApple();
            } else {
                snake.pop();
            }

        }

        document.addEventListener('keydown', function (event) {
            switch (event.keyCode) {
                case 37:
                    if (direction != 'right') {
                        direction = 'left';
                    }
                    break;
                case 38:
                    if (direction != 'down') {
                        direction = 'up';
                    }
                    break;
                case 39:
                    if (direction != 'left') {
                        direction = 'right';
                    }
                    break;
                case 40:
                    if (direction != 'up') {
                        direction = 'down';
                    }
                    break;
            }
        });

        function gameLoop() {
            if (!gameover) {
                move();
                draw();
                setTimeout(gameLoop, 100);
            } else {
                ctx.fillStyle = 'white';
                ctx.font = 'bold 48px sans-serif';
                ctx.fillText('GAME OVER', 50, 200);
            }
        }
        generateApple();
        gameLoop();
    </script>
</body>

</html>