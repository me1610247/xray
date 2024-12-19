<!DOCTYPE html>
<html>
<head>
    <title>Analysis Results</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom, #e0f7fa, #f0f2f5);
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #004d40;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .result-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 600px;
            animation: fadeIn 1s ease-in-out;
            text-align: center;
            position: relative;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .result-item {
            margin-bottom: 15px;
            font-size: 18px;
            background: #e3f2fd;
            border-left: 5px solid #004d40;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .result-item:hover {
            transform: scale(1.02);
        }

        .result-item span {
            font-weight: bold;
            color: #004d40;
        }

        .image-container {
            margin: 20px 0;
        }

        .image-container img {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .button-container {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #004d40;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background: #00392f;
            transform: translateY(-2px);
        }

        .spinner {
            display: none;
            margin: 10px auto;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .raw-response {
            margin-top: 20px;
            text-align: left;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            font-family: monospace;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 600px) {
            .result-container {
                padding: 20px;
            }

            button {
                font-size: 14px;
            }

            .result-item {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <h1>Analysis Results</h1>

    <div class="result-container">
        @if(session('predictionData'))
            <div class="result-item">
                <span>Predicted Label:</span> {{ session('predictionData.label') }}
            </div>
            <div class="result-item">
                <span>Confidence:</span> {{ session('predictionData.confidence') }}
            </div>
    
            @if(null !== session('predictionData.description'))
                <div class="result-item">
                    <span>Description:</span> {{ session('predictionData.description') }}
                </div>
                <div class="result-item">
                    <span>Description Confidence:</span> {{ session('predictionData.description_confidence') }}
                </div>
            @endif
    
            @if(null !== session('predictionData.recommendation'))
                <div class="result-item">
                    <span>Recommendation:</span> {{ session('predictionData.recommendation') }}
                </div>
            @endif
    
            @if(null !== session('predictionData.image'))
                <div class="image-container">
                    <img src="{{ asset(session('predictionData.image')) }}" alt="Uploaded Image" style="max-width: 100%; height: auto;">
                </div>
            @endif
    
            <div class="raw-response">
                <span>Raw Response:</span>
                <pre>{{ json_encode(session('predictionData.raw_response'), JSON_PRETTY_PRINT) }}</pre>
            </div>
        @else
            <div class="result-item">
                No prediction data available.
            </div>
        @endif
    
        <div class="button-container">
            <button onclick="window.location.href='{{ route('upload.form') }}'">Upload Another Image</button>
            <button onclick="window.location.href='{{ route('specializations.index')}}'">Ask Doctor</button>
            <button onclick="window.location.href='{{ route('download.results') }}'">Download Results as PDF</button>
        </div>
    </div>
    
</body>
</html>
