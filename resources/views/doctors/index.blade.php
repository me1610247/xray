<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors in Specialization</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7fafc;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #00796b;
            margin: 30px 0;
            font-size: 2.5em;
            font-weight: bold;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }
        .doctor-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        .doctor-info {
            flex-grow: 1;
            padding-right: 15px;
        }
        .doctor-info h2 {
            margin: 0;
            color: #00796b;
            font-size: 1.2em;
        }
        .doctor-info p {
            margin: 5px 0;
            color: #555;
        }
        .btn-message {
            display: inline-block;
            background: #00796b;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-message:hover {
            background-color: #004d40;
        }
        .message-form {
            display: none;
            margin-top: 10px;
            text-align: left;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        .message-form p {
            font-size: 1em;
            color: #00796b;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .message-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .message-form input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 12px;
            background: #f0f0f0;
            margin-bottom: 10px;
            cursor: not-allowed;
            font-size: 0.9em;
            color: #333;
        }
        .message-form label {
            display: block;
            margin-bottom: 5px;
            color: #00796b;
            font-weight: bold;
        }
        .message-form input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 12px;
            background: #f0f0f0;
            margin-bottom: 10px;
            cursor: pointer;
            display: block;
            font-size: 0.9em;
        }
        .message-form input[type="file"]::file-selector-button {
            background-color: #00796b;
            color: white;
            border-radius: 12px;
            padding: 5px 10px;
            cursor: pointer;
            border: none;
        }
        .message-form input[type="file"]::file-selector-button:hover {
            background-color: #004d40;
        }
        .message-form button {
            background: #00796b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .message-form button:hover {
            background-color: #004d40;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
            margin: 30px 0;
        }
    </style>
</head>
<body>

    <h1>Doctors in {{ ucwords($specialization->name) }} Specialization</h1>

    @if($doctors->isEmpty())
        <p class="no-data">No doctors found for this specialization.</p>
    @else
        <div class="container">
            @foreach($doctors as $doctor)
                <div class="doctor-card">
                    <div class="doctor-info">
                        <h2>{{ $doctor->name }}</h2>
                        <p>Contact: {{ $doctor->contact }}</p>
                    </div>
                    <button class="btn-message" onclick="showMessageForm({{ $doctor->id }}, '{{ $doctor->contact }}', '{{ $doctor->email }}')">Send Message</button>
                    <div id="message-form-{{ $doctor->id }}" class="message-form">
                        <p>Send your message to:</p>
                        <input type="text" id="doctor-contact-{{ $doctor->id }}" value="" readonly>
                        <form action="{{ route('send.message', ['doctor_id' => $doctor->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="message">Your Message:</label>
                            <textarea name="message" placeholder="Write your message here..." required></textarea>
                            
                            <label for="pdf-file">Upload PDF (e.g., reports):</label>
                            <input type="file" name="pdf_file" accept="application/pdf" required>
                            
                            <label for="image-file">Upload X-ray Image:</label>
                            <input type="file" name="image_file" accept="image/*" required>
                            
                            <button type="submit">Send</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <script>
        function showMessageForm(doctorId, contact) {
            const form = document.getElementById(`message-form-${doctorId}`);
            const contactInput = document.getElementById(`doctor-contact-${doctorId}`);

            contactInput.value = contact;

            form.style.display = form.style.display === 'block' ? 'none' : 'block';
        }
    </script>

</body>
</html>
