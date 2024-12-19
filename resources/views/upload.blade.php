<!DOCTYPE html>
<html>
<head>
    <title>Upload Medical Image for Analysis</title>
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

        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 800px;
            animation: fadeIn 1s ease-in-out;
        }

        .model-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 20px;
        }

        .model-card {
            flex: 1 1 45%;
            text-align: center;
            padding: 20px;
            border: 2px solid #004d40;
            border-radius: 12px;
            background: #e0f2f1;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
            color: #004d40;
        }

        .model-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 77, 64, 0.2);
            background: #b2dfdb;
        }

        .model-card.selected {
            background: #004d40;
            color: white;
        }

        .file-input-container {
            text-align: center;
            margin-bottom: 20px;
        }

        #imageInput {
            display: none;
        }

        .custom-file-label {
            display: inline-block;
            padding: 12px 25px;
            background: #004d40;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .custom-file-label:hover {
            background: #00332e;
        }

        .image-container {
            position: relative;
            width: 100%;
            max-width: 350px;
            height: 350px;
            border: 2px solid #004d40;
            border-radius: 12px;
            overflow: hidden;
            margin: 20px auto;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .scan-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            animation: scan 5s linear;
            z-index: 10;
            display: none;

        }

        @keyframes scan {
            0% {
                background: linear-gradient(to bottom, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.8) 100%);
                transform: translateY(-100%);
            }
            50% {
                transform: translateY(0%);
            }
            100% {
                transform: translateY(100%);
            }
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
            transition: background-color 0.3s;
        }

        button:hover {
            background: #00332e;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Upload Medical Image for Analysis</h1>

    <div class="form-container">
        <form id="uploadForm" action="{{ route('analyze.image') }}" method="POST" enctype="multipart/form-data">
            @csrf
    
            <!-- Model Selection -->
            <div class="model-cards">
                <div class="model-card" data-model="chest">
                    <i class="fas fa-lungs"></i>
                    <h3>Chest X-ray</h3>
                    <p>Detect and classify abnormalities such as pneumonia or lung conditions.</p>

                </div>
                <div class="model-card" data-model="bone">
                    <i class="fas fa-bone"></i>
                    <h3>Bone Fracture</h3>
                    <p>Identify and classify different types of bone fractures.</p>

                </div>
                <div class="model-card" data-model="brain">
                    <i class="fas fa-brain"></i>
                    <h3>Brain Tumor</h3>
                    <p>Analyze brain MRI scans to classify and predict tumor presence.</p>

                </div>
                <div class="model-card" data-model="knee">
                    <i class="fas fa-user-injured"></i>
                    <h3>Knee MRI</h3>
                    <p>Evaluate knee MRI images to detect abnormalities and provide a description.</p>

                </div>
            </div>
            <input type="hidden" name="model_type" id="modelType" required>
    
            <!-- File Input -->
            <div class="file-input-container hidden" id="fileInputContainer">
                <label class="custom-file-label" for="imageInput">Choose Image</label>
                <input type="file" name="image" id="imageInput" accept="image/*" required>
            </div>
    
            <!-- Image Preview -->
            <div class="image-container hidden" id="imageContainer">
                <img id="imagePreview" alt="Uploaded Image">
                <div class="scan-overlay" id="scanOverlay"></div>
            </div>
    
            <!-- Submit Button -->
            <button type="submit" class="hidden" id="analyzeButton">Analyze</button>
        </form>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
        const modelCards = document.querySelectorAll('.model-card');
        const modelTypeInput = document.getElementById('modelType');
        const fileInputContainer = document.getElementById('fileInputContainer');
        const analyzeButton = document.getElementById('analyzeButton');
        const imageInput = document.getElementById('imageInput');
        const imageContainer = document.getElementById('imageContainer');
        const imagePreview = document.getElementById('imagePreview');
        const scanOverlay = document.getElementById('scanOverlay');
    
        // Handle model selection
        modelCards.forEach(card => {
            card.addEventListener('click', function () {
                modelCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                modelTypeInput.value = this.dataset.model;
    
                // Show the "Choose Image" button
                fileInputContainer.classList.remove('hidden');
                analyzeButton.classList.add('hidden');
            });
        });
    
        // Handle image selection
        imageInput.addEventListener('change', function (e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();
    
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imageContainer.classList.remove('hidden');
                };
    
                reader.readAsDataURL(file);
                analyzeButton.classList.remove('hidden');
            } else {
                analyzeButton.classList.add('hidden');
                imageContainer.classList.add('hidden');
            }
        });
    
        // Handle Analyze button click
        analyzeButton.addEventListener('click', function (e) {
            e.preventDefault();
            imageContainer.classList.remove('hidden');
            scanOverlay.style.display = 'block';
            scanOverlay.style.animation = 'scan 5s linear';
    
            setTimeout(() => {
                scanOverlay.style.display = 'none';
                document.getElementById('uploadForm').submit();
            }, 5000);
        });
    </script>
</body>
</html>
