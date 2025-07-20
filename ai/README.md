# Digestive Disease Prediction Model

This project provides a machine learning model for predicting digestive system diseases based on symptom data. The model is designed to be integrated with a PHP Laravel web application.

## Target Diseases

The model is trained to predict the following 10 digestive system conditions:

1. GERD
2. Peptic ulcer disease
3. Gastroenteritis
4. Jaundice
5. Hepatitis A
6. Hepatitis B
7. Hepatitis C
8. Hepatitis D
9. Hepatitis E
10. Alcoholic hepatitis

## Project Structure

```
.
├── digestive_diseases.csv    # Dataset file
├── main.py                  # Main model training script
├── inference.py             # Inference script for predictions
├── requirements.txt         # Python dependencies
├── models/                  # Directory for storing trained models
├── eda_results/             # Exploratory data analysis results
└── model_evaluation/        # Model performance metrics
```

## Setup Instructions

### Prerequisites

- Python 3.8+
- pip (Python package manager)

### Installation

1. Clone this repository:
   ```
   git clone <repository-url>
   cd digestive-disease-prediction
   ```

2. Install the required dependencies:
   ```
   pip install -r requirements.txt
   ```

3. Train the model:
   ```
   python main.py
   ```
   This will:
   - Load and preprocess the data
   - Perform exploratory data analysis (results saved in `eda_results/`)
   - Train and optimize a Random Forest classifier
   - Evaluate model performance (results saved in `model_evaluation/`)
   - Save the trained model in the `models/` directory

## Using the Model

### Command Line Interface

You can use the model to make predictions via the command line:

```
python inference.py "symptom1,symptom2,symptom3"
```

Example:
```
python inference.py "stomach_pain,acidity,vomiting,chest_pain"
```

### API Server

The model can also be used as an API server:

1. Start the API server:
   ```
   python inference.py --api
   ```
   This will start a Flask server at http://127.0.0.1:5000

2. Make predictions by sending POST requests to `/predict` endpoint:
   ```
   curl -X POST http://127.0.0.1:5000/predict \
       -H "Content-Type: application/json" \
       -d '{"symptoms": ["stomach_pain", "acidity", "vomiting", "chest_pain"]}'
   ```

### API Response Format

The API returns a JSON response with the following structure:

```json
{
  "predicted_disease": "GERD",
  "confidence": 0.85,
  "top_diseases": [
    {
      "disease": "GERD",
      "probability": 0.85
    },
    {
      "disease": "Peptic ulcer diseae",
      "probability": 0.10
    },
    {
      "disease": "Gastroenteritis",
      "probability": 0.05
    }
  ]
}
```

## Integration with Laravel PHP Application

### Requirements

- PHP 7.4+
- Laravel 8+
- PHP cURL extension

### Setting Up

1. Deploy the Python model and inference script on your server.

2. Set up the API server:
   ```
   python inference.py --api
   ```

3. Create a Laravel controller to interact with the API:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DiagnosisController extends Controller
{
    public function predict(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'symptoms' => 'required|array',
            'symptoms.*' => 'required|string'
        ]);

        // Send request to Python API
        $response = Http::post('http://127.0.0.1:5000/predict', [
            'symptoms' => $request->symptoms
        ]);

        // Check for successful response
        if ($response->successful()) {
            return response()->json($response->json());
        }

        // Handle errors
        return response()->json([
            'error' => 'Failed to get prediction',
            'details' => $response->body()
        ], 500);
    }
}
```

4. Add the route in your `routes/api.php`:

```php
Route::post('/diagnose', 'App\Http\Controllers\DiagnosisController@predict');
```

5. You can now make requests to your Laravel application:

```
POST /api/diagnose
Content-Type: application/json

{
  "symptoms": ["stomach_pain", "acidity", "vomiting", "chest_pain"]
}
```

### Alternative: Direct PHP Execution

If you prefer not to use the API, you can directly execute the Python script from PHP:

```php
public function predict(Request $request)
{
    // Validate incoming request
    $request->validate([
        'symptoms' => 'required|array',
        'symptoms.*' => 'required|string'
    ]);

    // Prepare symptoms for the command
    $symptomsString = implode(',', $request->symptoms);

    // Execute Python script
    $command = escapeshellcmd("python /path/to/inference.py \"{$symptomsString}\"");
    $output = shell_exec($command);

    // Parse JSON response
    $result = json_decode($output, true);

    return response()->json($result);
}
```

## Production Deployment Considerations

1. **Security**:
   - Do not expose the API directly to the internet
   - Implement authentication for the API
   - Validate all inputs on both Laravel and Python sides

2. **Performance**:
   - Consider using a WSGI server like Gunicorn for the Flask API
   - Load the model once at startup to avoid loading it for each request

3. **Dependencies**:
   - Ensure all required Python packages are installed on the production server
   - Use a virtual environment to isolate dependencies

4. **Error Handling**:
   - Implement robust error handling in both Python and PHP code
   - Log errors properly for debugging

5. **Monitoring**:
   - Add logging to track model usage and performance
   - Monitor server resource usage (especially memory, as the model requires RAM)

## Model Performance

The trained Random Forest model achieves the following performance metrics:

- Accuracy: ~0.95 (may vary with different training runs)
- F1-Score: ~0.94 (weighted average)

Detailed metrics are available in the `model_evaluation/` directory after training.

## Common Symptoms and their Format

When submitting symptoms, use the exact format as in the training data. Here are some common symptoms:

- stomach_pain
- acidity
- vomiting
- chest_pain
- abdominal_pain
- yellowish_skin
- fatigue
- nausea
- loss_of_appetite
- dark_urine
- etc.

A complete list of symptoms can be found in the EDA results directory after training. 