<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosis Result - Health Pulse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .main-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        .header {
            text-align: center;
            margin-bottom: 2rem;
            color: #2c3e50;
        }
        .disease-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .disease-header {
            padding: 1.5rem;
            background-color: #3498db;
            color: white;
        }
        .confidence-meter {
            height: 10px;
            background-color: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
            margin: 1rem 0;
        }
        .confidence-value {
            height: 100%;
            background-color: #2ecc71;
        }
        .symptom-tag {
            display: inline-block;
            background-color: #e8f4fd;
            color: #3498db;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        .alternatives {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
        }
        .back-btn {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="header">
            <h1>Diagnosis Result</h1>
            <p class="lead">Based on your symptoms, our model predicts:</p>
        </div>
        
        <div class="disease-card">
            <div class="disease-header">
                <h2 class="mb-0">{{ $result['predicted_disease'] }}</h2>
                <p class="mb-0 opacity-75">Primary diagnosis</p>
            </div>
            
            <div class="card-body">
                <h5>Confidence Level: {{ number_format($result['confidence'] * 100, 1) }}%</h5>
                
                <div class="confidence-meter">
                    <div class="confidence-value" style="width: {{ $result['confidence'] * 100 }}%;"></div>
                </div>
                
                <h5>Your Reported Symptoms:</h5>
                <div>
                    @foreach($selectedSymptoms as $symptom)
                        <span class="symptom-tag">{{ $symptom->display_name }}</span>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    <h5>Alternative Possibilities:</h5>
                    <div class="alternatives">
                        <ul class="list-group list-group-flush">
                            @foreach($result['top_diseases'] as $index => $disease)
                                @if($index > 0) {{-- Skip the first one as it's already shown above --}}
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $disease['disease'] }}
                                        <span class="badge bg-primary rounded-pill">{{ number_format($disease['probability'] * 100, 1) }}%</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <div class="mt-4 alert alert-warning">
                    <h6 class="mb-1">Important Disclaimer</h6>
                    <p class="mb-0 small">This is not a medical diagnosis. Always consult with a healthcare professional for proper medical advice and treatment.</p>
                </div>
            </div>
        </div>
        
        <div class="text-center">
            <a href="{{ route('diagnosis') }}" class="btn btn-primary back-btn">Check Again</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</x-app-layout>