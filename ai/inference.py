import pandas as pd
import pickle
import json
import os
import sys
from flask import Flask, request, jsonify

# Load the model and required files
def load_model_files(model_dir='models'):
    """
    Load the trained model and associated files
    """
    with open(os.path.join(model_dir, 'random_forest_model.pkl'), 'rb') as f:
        model = pickle.load(f)
    
    with open(os.path.join(model_dir, 'feature_names.pkl'), 'rb') as f:
        feature_names = pickle.load(f)
    
    with open(os.path.join(model_dir, 'label_encoder.pkl'), 'rb') as f:
        label_encoder = pickle.load(f)
    
    return model, feature_names, label_encoder

def predict_disease(symptoms, model, feature_names, label_encoder):
    """
    Predict disease based on symptoms
    
    Args:
        symptoms: List of symptoms as strings
        model: Trained model
        feature_names: List of all feature names (symptoms)
        label_encoder: LabelEncoder for disease names
    
    Returns:
        Predicted disease and confidence score
    """
    # Create a dataframe with all features
    input_df = pd.DataFrame(columns=feature_names)
    input_df.loc[0] = 0  # Initialize with zeros
    
    # Set the symptoms that are present
    for symptom in symptoms:
        if symptom in feature_names:
            input_df.loc[0, symptom] = 1
    
    # Make prediction
    prediction_proba = model.predict_proba(input_df)
    prediction_idx = prediction_proba.argmax()
    confidence = prediction_proba[0, prediction_idx]
    predicted_disease = label_encoder.inverse_transform([prediction_idx])[0]
    
    # Get top 3 possible diseases with probabilities
    top_indices = prediction_proba[0].argsort()[-3:][::-1]
    top_diseases = [
        {
            "disease": label_encoder.inverse_transform([idx])[0],
            "probability": float(prediction_proba[0, idx])
        }
        for idx in top_indices
    ]
    
    return {
        "predicted_disease": predicted_disease,
        "confidence": float(confidence),
        "top_diseases": top_diseases
    }

# Command-line interface
def predict_from_cli():
    """
    Make prediction from command-line arguments
    
    Usage:
    python inference.py "symptom1,symptom2,symptom3,..."
    """
    if len(sys.argv) < 2:
        print("Usage: python inference.py \"symptom1,symptom2,symptom3,...\"")
        sys.exit(1)
    
    symptoms = sys.argv[1].split(',')
    symptoms = [s.strip() for s in symptoms]
    
    model, feature_names, label_encoder = load_model_files()
    result = predict_disease(symptoms, model, feature_names, label_encoder)
    
    print(json.dumps(result, indent=2))

# Flask API
app = Flask(__name__)

@app.route('/predict', methods=['POST'])
def predict_api():
    """
    API endpoint for making predictions
    
    Expects a JSON with the following format:
    {
        "symptoms": ["symptom1", "symptom2", "symptom3", ...]
    }
    """
    try:
        data = request.get_json()
        
        if not data or 'symptoms' not in data:
            return jsonify({"error": "Invalid request format. Expected 'symptoms' field."}), 400
        
        symptoms = data['symptoms']
        
        if not isinstance(symptoms, list):
            return jsonify({"error": "'symptoms' should be a list of strings."}), 400
        
        model, feature_names, label_encoder = load_model_files()
        result = predict_disease(symptoms, model, feature_names, label_encoder)
        
        return jsonify(result)
    
    except Exception as e:
        return jsonify({"error": str(e)}), 500

# Run the API server if run as a script with --api flag
if __name__ == "__main__":
    if len(sys.argv) > 1 and sys.argv[1] == "--api":
        print("Starting API server on http://127.0.0.1:5000")
        print("Use the /predict endpoint for predictions")
        app.run(debug=True)
    else:
        predict_from_cli() 