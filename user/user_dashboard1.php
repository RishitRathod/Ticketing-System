<?php
include './userdashnav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS -->
    <style>
        body{
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
        }
        main {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        .navbar-brand img {
            height: 90px;
        }

        .events, .tickets {
            color: white;
            font-size: 30px;
            font-weight: bolder;
            background-size: cover;
            box-shadow: 0 0 150px #000 inset;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 150px;
        }

        .events {
            background-image: url("https://png.pngtree.com/background/20221109/original/pngtree-event-management-doodle-set-picture-image_1952957.jpg");
        }

        .tickets {
            background-image: url("https://copycatjm.com/wp-content/uploads/2022/08/Tickets-Prod-Image.jpg");
        }

        .events:hover, .tickets:hover {
            color: black;
            box-shadow: 0 10px 20px #000000 inset, 0 0 200px #00000000 inset, 0 0 150px #00000000 inset, 0 0 100px #00000034 inset;
        }


        .ls {
            color: white;
            background-color: green;
            border: 5px solid black;
            border-radius: 30px;
            box-shadow: 0px 5px black;
        }

        .ls:hover {
            color: green;
            background-color: rgb(0, 255, 38);
            border: 5px solid black;
            border-radius: 30px;
            transition: 100ms;
        }

        .ls:active {
            transform: translateY(3px);
            background-color: green;
            box-shadow: 0px 1px rgba(175, 255, 175, 0.455);
        }

        .carousel-container {
            position: relative;
            width: 80%;
            max-width: 800px;
            margin: auto;
        }

        .carousel-item img {
            width: 100%;
        }
        
        .scroll-container {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            padding: 10px;
            background-color: #f8f9fa00;
        }
        .scroll-item:hover{
            color: black;
            font-size: x-large;
            font-weight: bold;
            padding-top: 50%;
            box-shadow: 0 10px 20px #000000 inset, 0 0 200px #00000000 inset, 0 0 150px #00000000 inset, 0 0 100px #00000034 inset;
            transform: translateY(-5px);
        }
        .scroll-container::-webkit-scrollbar {
            display: none;
        }
        .scroll-item {
            display: inline-block;
            min-width: 200px;
            max-width: 500px;
            height: 100px;
            background-color: #007bff;
            color: white;
            border-radius: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
  
    <main>
        <div class="container text-center m-4 py-4">
            <div class="row m-4 justify-content-evenly">
                <div class="events col-5 p-3 p-md-5 rounded-pill btn btn-secondary">
                    Events
                </div>
                <div class="tickets col-5 p-3 p-md-5 rounded-pill btn btn-secondary">
                    Tickets
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row">
                <h4>All Categories</h4>
            </div>
            <div class="scroll-container text-center p-3">
                <a class="scroll-item btn btn-outline-primary m-2 py-3 px-5 rounded-6">Beauty</a>
                <a class="scroll-item btn btn-outline-primary m-2 py-3 px-5 rounded-6">Bussiness</a>
                <a class="scroll-item btn btn-outline-primary m-2 py-3 px-5 rounded-6">Comedy</a>
                <a class="scroll-item btn btn-outline-primary m-2 py-3 px-5 rounded-6">Culture</a>
                <a class="scroll-item btn btn-outline-primary m-2 py-3 px-5 rounded-6">Dance</a>
                <a class="scroll-item btn btn-outline-primary m-2 py-3 px-5 rounded-6">Education</a>
                <a class="scroll-item btn btn-outline-primary m-2 py-3 px-5 rounded-6">Experience</a>
                <a class="scroll-item btn btn-outline-primary m-2 py-3 px-5 rounded-6">Health</a>
                <a class="scroll-item btn btn-outline-primary m-2 py-3 px-5 rounded-6">Music</a>   
                <a class="scroll-item btn btn-outline-primary m-2 py-3 px-5 rounded-6">Sports</a>            
            </div>
        </div>
    </main>


    <footer class="bg-body-tertiary p-3 text-center text-lg-start">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Copyright:
            <a class="text-body" href="#">Event Scheduler</a>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        
    </script>
</body>
</html>
