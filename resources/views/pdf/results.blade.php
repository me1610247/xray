<!-- resources/views/pdf/results.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Analysis Results</title>
</head>
<body>
    <h1>Prediction Results</h1>

    <!-- Display user name -->
    <p><strong>Patient:</strong> {{ Auth::user()->name }}</p>

    <!-- Display the model name -->
    <p><strong>Model Type:</strong> {{ ucwords($modelType) }}</p>

    <p><strong>Label:</strong> {{ $predictionData->label }}</p>
    <p><strong>Confidence:</strong> {{ $predictionData->confidence }}</p>
    <p><strong>Recommendation:</strong> {{ $predictionData->recommendation }}</p>

    @if($predictionData->description)
        <p><strong>Description:</strong> {{ $predictionData->description }}</p>
        <p><strong>Description Confidence:</strong> {{ $predictionData->description_confidence }}</p>
    @endif

    <pre><strong>Raw Response:</strong> {{ json_encode(json_decode($predictionData->raw_response), JSON_PRETTY_PRINT) }}</pre>
</body>
</html>
