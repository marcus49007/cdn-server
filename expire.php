<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Project Expired</title>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
        background: linear-gradient(135deg, #ff4e50, #f9d423);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0px 10px 25px rgba(0,0,0,0.2);
        text-align: center;
        max-width: 420px;
        width: 90%;
        animation: fadeIn 1s ease-in-out;
    }

    h1 {
        color: #ff4e50;
        margin-bottom: 15px;
    }

    p {
        color: #444;
        font-size: 16px;
        margin-bottom: 25px;
    }

    .contact-btn {
        display: inline-block;
        padding: 12px 25px;
        background: #ff4e50;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        transition: 0.3s;
        font-weight: bold;
    }

    .contact-btn:hover {
        background: #d63b3d;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
</head>

<body>

<div class="container">
    <h1>Project Expired</h1>
    <p>
        This project license has expired.<br><br>
        Please contact <strong>Shiv Infotech</strong> to repurchase or renew the project.
    </p>

    <a href="mailto:shivinfotech@example.com" class="contact-btn">
        Contact Support
    </a>
</div>

</body>
</html>
