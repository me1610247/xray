<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specializations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff; /* Light blue background for better readability */
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            background: linear-gradient(45deg, #00796b, #004d40); /* Gradient for a modern look */
            color: white;
            padding: 20px 0;
            text-align: center;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        header h1 {
            margin: 0;
            font-size: 3em;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .specializations-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        .specialization {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .specialization:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .specialization i {
            font-size: 3em;
            color: #00796b;
            margin-bottom: 15px;
        }
        .specialization h3 {
            font-size: 1.8em;
            color: #003366;
            margin-bottom: 10px;
        }
        .specialization p {
            color: #555;
            margin: 5px 0;
            font-size: 1em;
        }
        .alert {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 4px;
            text-align: center;
            font-weight: bold;
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
        @media (max-width: 768px) {
            .specialization {
                padding: 15px;
            }
            .specialization i {
                font-size: 2.5em;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Specializations</h1>
    </header>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    <div class="container">
        @if($specializations->count() > 0)
            <section class="specializations-section">
                @foreach($specializations as $specialization)
                    <a href="{{ route('specializations.showDoctors', $specialization->id) }}">
                        <div class="specialization">
                            <i class="fas fa-user-md"></i>
                            <h3>{{ ucwords($specialization->name) }}</h3>
                            <p>{{ $specialization->description }}</p>
                            <p>Number of doctors: <strong>{{ $specialization->doctors_count }}</strong></p>
                        </div>
                    </a>
                @endforeach
            </section>
        @else
            <p style="text-align: center; font-style: italic; color: #555;">No specializations available.</p>
        @endif
    </div>
</body>
</html>
