<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="./js/user.js" defer></script>
    <link rel="stylesheet" href="./css/global.css">
    <script src="./js/toogleAsideBar.js" defer></script>
</head>

<body class="">
    <header class="grid h-16 w-full grid-cols-3 justify-between border-2 border-t-[1px] border-x-4 border-gray-300 px-2">
        <nav class="w-16">
            <ul class="flex">
                <li>
                    <a href="./" class=""><img class="p-1 aspect-square max-w-[calc(4rem_-_4px)] mt-0.5" src="https://avatars.githubusercontent.com/u/6693385?s=200&v=4" alt="" /></a>
                </li>
                <li>
                    <div class="container" onclick="myFunction(this)">
                        <div class="bar1"></div>
                        <div class="bar2"></div>
                        <div class="bar3"></div>
                    </div>
                </li>
            </ul>

        </nav>
        <nav class="flex w-16 mb-1 items-center justify-center text-2xl font-bold place-self-center">
            <a href="./">Inicio</a>
        </nav>
        <nav class="flex place-self-end">
            <div class="h-16 pt-4 text-xl font-semibold mr-2">(Master)</div>
            <div id="icon_user">
                <img class="p-1.5 aspect-square max-h-[calc(4rem_-_4px)] rounded-full" src="https://cdn-icons-png.freepik.com/256/10302/10302971.png?semt=ais_hybrid" alt="" />
                <div class="absolute h-20 w-32 right-2 top-[4.25rem] border-2 border-gray-300 rounded-lg bg-gray-200 hidden">
                    <ul class="flex flex-col p-2 text-lg font-medium">
                        <li><a href="perfil">perfil</a></li>
                        <span class="bg-gray-300 h-0.5"></span>
                        <li><a href="">cerrar sesion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="h-[calc(100vh_-_64px)]">

    </main>
</body>

</html>