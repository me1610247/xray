<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Online Clinic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
     
        .services {
            display: flex;
            justify-content: space-around;
            margin: 40px 0;
        }
        .service {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            flex: 1;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        .service:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .service i {
            font-size: 3em;
            color: #004d40;
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            background: #004d40; /* Dark teal color */
            color: white;
            position: relative;
        }
        header {
            background: #004d40; /* Dark teal color */
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        header h1 {
            margin: 0;
            font-size: 2.8em; /* Emphasis */
            font-weight: 700;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }
        .hero {
            background: url('https://source.unsplash.com/1600x900/?medical,clinic') no-repeat center center/cover;
            height: 350px; /* Adjusted height */
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            color: white;
            text-align: center;
            overflow: hidden;
        }
        .hero-content {
            background: rgba(255, 255, 255, 0.7); /* Semi-transparent white for readability */
            padding: 40px 60px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }
        .hero h2 {
            margin: 0;
            font-size: 3.5em;
            font-weight: 700;
            line-height: 1.3;
            color: #003366; /* Dark blue for trust */
        }
        .hero p {
            margin-top: 15px;
            font-size: 1.4em;
            font-weight: 300;
            color: #004d40; /* Dark green for health */
        }
        @media (max-width: 768px) {
            .services {
                flex-direction: column;
                align-items: center;
            }
            .service {
                margin: 20px 0;
            }
        }
        .service-link {
            text-decoration: none; /* Remove underline */
            color: inherit; /* Keep the text color of the service */
            display: block; /* Make the link behave like a block element */
        }
        .service-link:hover .service {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .alert {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 4px;
            text-align: center;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <header>
        <h1>Welcome to Our Online Clinic</h1>
    </header>
    @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert error">{{ session('error') }}</div>
@endif
    <div class="hero">
        <div class="hero-content">
            <h2>Your Health, Our Priority</h2>
            <p>Experience top-tier healthcare and X-ray analysis, anytime, anywhere.</p>
        </div>
    </div>

    <div class="container">
        <section class="services">
            <a href="/specializations" class="service-link">
                <div class="service">
                    <i class="fas fa-user-md"></i>
                    <h3>Consult a Doctor</h3>
                    <p>Get online consultations with qualified doctors from the comfort of your home.</p>
                </div>
            </a>

            <a href="/upload" class="service-link">
                <div class="service">
                    <i class="fas fa-x-ray"></i>
                    <h3>X-Ray Detection</h3>
                    <p>Upload your X-ray images for accurate analysis and diagnosis.</p>
                </div>
            </a>

            <a href="/health-records" class="service-link">
                <div class="service">
                    <i class="fas fa-file-medical"></i>
                    <h3>Health Records</h3>
                    <p>Access and manage your health records securely online.</p>
                </div>
            </a>
        </section>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Online Clinic. All rights reserved.</p>
    </footer>

</body>
</html>
