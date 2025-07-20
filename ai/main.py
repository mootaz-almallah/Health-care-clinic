import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
from sklearn.model_selection import train_test_split, GridSearchCV
from sklearn.preprocessing import LabelEncoder
from sklearn.metrics import classification_report, confusion_matrix, accuracy_score
from sklearn.ensemble import RandomForestClassifier
import pickle
import os
import warnings
warnings.filterwarnings('ignore')

# List of target digestive diseases to include in the model
TARGET_DISEASES = [
    'GERD', 
    'Peptic ulcer diseae',
    'Gastroenteritis',
    'Jaundice',
    'Hepatitis A',
    'Hepatitis B',
    'Hepatitis C',
    'Hepatitis D',
    'Hepatitis E',
    'Alcoholic hepatitis'
]

def load_and_filter_data(filepath='digestive_diseases.csv'):
    """
    Load the dataset and filter to only include target digestive diseases
    """
    df = pd.read_csv(filepath)
    
    # Filter to only include the target diseases
    df = df[df['Disease'].isin(TARGET_DISEASES)]
    
    return df

def preprocess_data(df):
    """
    Preprocess the data by:
    1. Creating a binary representation of symptoms
    2. Handling missing values
    3. Encoding the disease labels
    """
    # Get unique symptoms from the dataset
    symptom_columns = [col for col in df.columns if col.startswith('Symptom_')]
    all_symptoms = set()
    
    for col in symptom_columns:
        # Extract non-null symptoms and convert to string if needed
        # This handles non-string values in symptom columns
        symptoms = []
        for val in df[col].dropna().values:
            if isinstance(val, str):
                symptoms.append(val.strip())
            else:
                symptoms.append(str(val).strip())
        
        all_symptoms.update(symptoms)
    
    # Remove any empty strings
    all_symptoms = {symptom for symptom in all_symptoms if symptom}
    
    print(f"Found {len(all_symptoms)} unique symptoms")
    
    # Create a dataframe with binary representation of symptoms
    X = pd.DataFrame(index=df.index)
    
    for symptom in all_symptoms:
        # Initialize the symptom column with zeros
        X[symptom] = 0
        
        # Check each symptom column for the symptom
        for col in symptom_columns:
            # Convert to string for comparison
            df[col] = df[col].fillna('')
            df[col] = df[col].astype(str).str.strip()
            X.loc[df[col] == symptom, symptom] = 1
    
    # Encode disease labels
    label_encoder = LabelEncoder()
    y = label_encoder.fit_transform(df['Disease'])
    
    # Create directories if they don't exist
    os.makedirs('models', exist_ok=True)
    
    # Save the label encoder for later use
    with open('models/label_encoder.pkl', 'wb') as f:
        pickle.dump(label_encoder, f)
    
    return X, y, all_symptoms, label_encoder
# هاض مقياس عالمي لجوده الmodles
def perform_eda(X, y, label_encoder):# هاض مقياس عالمي لجوده الmodles
    """
    Perform exploratory data analysis on the processed data
    """
    # Create output directory for plots
    os.makedirs('eda_results', exist_ok=True)
    
    # Check class distribution
    disease_counts = pd.Series(y).value_counts().sort_index()
    disease_names = label_encoder.inverse_transform(disease_counts.index)
    
    plt.figure(figsize=(12, 6))
    bars = plt.bar(disease_names, disease_counts.values)
    plt.xticks(rotation=45, ha='right')
    plt.title('Distribution of Digestive Diseases')
    plt.ylabel('Count')
    plt.tight_layout()
    plt.savefig('eda_results/disease_distribution.png')
    
    # Check symptom distribution
    symptom_counts = X.sum().sort_values(ascending=False)
    
    plt.figure(figsize=(12, 8))
    plt.barh(symptom_counts.index[:20], symptom_counts.values[:20])
    plt.title('Top 20 Most Common Symptoms')
    plt.xlabel('Count')
    plt.tight_layout()
    plt.savefig('eda_results/top_symptoms.png')
    
    # Create a correlation matrix between symptoms
    corr_matrix = X.corr()
    
    plt.figure(figsize=(14, 12))
    sns.heatmap(corr_matrix, annot=False, cmap='coolwarm', linewidths=0.5)
    plt.title('Symptom Correlation Matrix')
    plt.tight_layout()
    plt.savefig('eda_results/symptom_correlation.png')
    
    # Create a summary of findings
    with open('eda_results/eda_summary.txt', 'w') as f:
        f.write("EDA Summary for Digestive Disease Prediction\n")
        f.write("===========================================\n\n")
        f.write(f"Total number of samples: {len(X)}\n")
        f.write(f"Number of features (symptoms): {X.shape[1]}\n")
        f.write(f"Number of classes (diseases): {len(label_encoder.classes_)}\n\n")
        
        f.write("Class Distribution:\n")
        for i, count in enumerate(disease_counts):
            f.write(f"  {label_encoder.classes_[i]}: {count} samples\n")
        
        f.write("\nTop 10 Most Common Symptoms:\n")
        for symptom, count in symptom_counts.head(10).items():
            f.write(f"  {symptom}: {count} occurrences\n")

def train_model(X, y):
    """
    Train a Random Forest classifier on the data
    """
    # Split the data into training and testing sets
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.25, random_state=42, stratify=y)
    
    # Train a Random Forest classifier
    param_grid = {
        'n_estimators': [100, 200, 300],
        'max_depth': [None, 10, 20, 30],
        'min_samples_split': [2, 5, 10],
        'min_samples_leaf': [1, 2, 4]
    }
    
    grid_search = GridSearchCV(
        RandomForestClassifier(random_state=42),
        param_grid=param_grid,
        cv=5,
        scoring='accuracy',
        n_jobs=-1
    )
    
    grid_search.fit(X_train, y_train)
    
    # Get the best model
    best_model = grid_search.best_estimator_
    
    # Evaluate on the test set
    y_pred = best_model.predict(X_test)
    
    # Calculate metrics
    accuracy = accuracy_score(y_test, y_pred)
    classification_rep = classification_report(y_test, y_pred)
    conf_matrix = confusion_matrix(y_test, y_pred)
    
    # Save model evaluation results
    os.makedirs('model_evaluation', exist_ok=True)
    
    with open('model_evaluation/model_metrics.txt', 'w') as f:
        f.write("Model Evaluation Metrics\n")
        f.write("=======================\n\n")
        f.write(f"Best Parameters: {grid_search.best_params_}\n\n")
        f.write(f"Accuracy: {accuracy:.4f}\n\n")
        f.write("Classification Report:\n")
        f.write(classification_rep)
    
    # Plot confusion matrix
    plt.figure(figsize=(12, 10))
    sns.heatmap(conf_matrix, annot=True, fmt='d', cmap='Blues')
    plt.xlabel('Predicted Label')
    plt.ylabel('True Label')
    plt.title('Confusion Matrix')
    plt.tight_layout()
    plt.savefig('model_evaluation/confusion_matrix.png')
    
    # Calculate and plot feature importances
    feature_importances = best_model.feature_importances_
    feature_names = X.columns
    
    feature_importance_df = pd.DataFrame({
        'Feature': feature_names,
        'Importance': feature_importances
    }).sort_values('Importance', ascending=False)
    
    plt.figure(figsize=(12, 8))
    sns.barplot(x='Importance', y='Feature', data=feature_importance_df.head(20))
    plt.title('Top 20 Most Important Symptoms')
    plt.tight_layout()
    plt.savefig('model_evaluation/feature_importance.png')
    
    # Save the best model
    os.makedirs('models', exist_ok=True)
    with open('models/random_forest_model.pkl', 'wb') as f:
        pickle.dump(best_model, f)
    
    # Save the feature names
    with open('models/feature_names.pkl', 'wb') as f:
        pickle.dump(list(feature_names), f)
    
    return best_model, X_test, y_test

def main():
    # Create necessary directories
    os.makedirs('models', exist_ok=True)
    os.makedirs('eda_results', exist_ok=True)
    os.makedirs('model_evaluation', exist_ok=True)
    
    # Load and filter the data
    print("Loading and filtering data...")
    df = load_and_filter_data()
    
    # Preprocess the data
    print("Preprocessing data...")
    X, y, all_symptoms, label_encoder = preprocess_data(df)
    
    # Perform EDA
    print("Performing exploratory data analysis...")
    perform_eda(X, y, label_encoder)
    
    # Train the model
    print("Training the model...")
    best_model, X_test, y_test = train_model(X, y)
    
    print("Model training complete!")
    print(f"Model accuracy on test set: {accuracy_score(y_test, best_model.predict(X_test)):.4f}")
    print("Results saved in 'model_evaluation' directory")
    print("Model saved in 'models' directory")

if __name__ == "__main__":
    main()
