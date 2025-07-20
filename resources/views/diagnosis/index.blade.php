<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Symptom Checker - Health Pulse</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
            overflow-x: hidden;
        }

        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        .shape:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; }
        .shape:nth-child(2) { width: 120px; height: 120px; left: 80%; animation-delay: 2s; }
        .shape:nth-child(3) { width: 60px; height: 60px; left: 45%; animation-delay: 4s; }
        .shape:nth-child(4) { width: 100px; height: 100px; left: 70%; animation-delay: 6s; }

        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header {
            text-align: center;
            padding: 3rem 0 2rem;
            color: white;
        }

        .header h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
            font-weight: 300;
        }

        .main-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .search-section {
            padding: 2rem;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
        }

        .search-box {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
        }

        .search-input {
            width: 100%;
            padding: 16px 50px 16px 20px;
            border: 2px solid transparent;
            border-radius: 50px;
            font-size: 1rem;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
        }

        .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
        }

        .filter-section {
            padding: 1.5rem 2rem;
            background: white;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .alphabet-filter {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .letter-btn {
            width: 36px;
            height: 36px;
            border: 2px solid #e0e7ff;
            background: white;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
        }

        .letter-btn:hover, .letter-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
            transform: translateY(-2px);
        }

        .clear-filters {
            background: #ef4444;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-left: auto;
        }

        .clear-filters:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        .symptoms-section {
            padding: 2rem;
        }

        .selected-count {
            text-align: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 16px;
            font-weight: 600;
        }

        .symptoms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .symptom-card {
            background: white;
            border: 2px solid #f1f5f9;
            border-radius: 12px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .symptom-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            opacity: 0;
            transition: opacity 0.2s ease;
            z-index: -1;
        }

        .symptom-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-color: #667eea;
        }

        .symptom-card.selected {
            border-color: #667eea;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .symptom-card.selected::before {
            opacity: 1;
        }

        .symptom-card.selected .symptom-text {
            color: white;
            position: relative;
            z-index: 1;
        }

        .symptom-checkbox {
            display: none;
        }

        .symptom-text {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            position: relative;
            z-index: 1;
        }

        .symptom-icon {
            width: 20px;
            height: 20px;
            border: 2px solid #cbd5e1;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .selected .symptom-icon {
            background: white;
            border-color: white;
            color: #667eea;
        }

        .submit-section {
            text-align: center;
            padding: 2rem;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
        }

        .submit-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 16px 40px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .no-symptoms {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }

        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .symptoms-grid { grid-template-columns: 1fr; gap: 0.75rem; }
            .filter-section { flex-direction: column; align-items: stretch; }
            .alphabet-filter { justify-content: center; }
            .clear-filters { margin-left: 0; align-self: center; }
        }
    </style>
</head>
<body>
 
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="container">
        <div class="header">
            <h1><i class="fas fa-heartbeat"></i> Symptom Checker</h1>
            <p>Select your symptoms for intelligent health insights</p>
        </div>

        <div class="main-card">
            <div class="search-section">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Search symptoms..." id="searchInput">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>

            <div class="filter-section">
                <div class="alphabet-filter" id="alphabetFilter"></div>
                <button class="clear-filters" onclick="clearAllFilters()">
                    <i class="fas fa-times"></i> Clear Filters
                </button>
            </div>

            <form method="POST" action="{{ route('predict') }}" id="symptomForm">
                @csrf
                <div class="symptoms-section">
                    <div class="selected-count" id="selectedCount">
                        <i class="fas fa-check-circle"></i> 0 symptoms selected
                    </div>
                    
                    <div class="symptoms-grid" id="symptomsGrid">
                        <!-- Symptoms will be populated by JavaScript -->
                    </div>

                    <div class="no-symptoms" id="noSymptoms" style="display: none;">
                        <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                        <h3>No symptoms found</h3>
                        <p>Try adjusting your search or filter criteria</p>
                    </div>
                </div>

                <div class="submit-section">
                    <button type="submit" class="submit-btn" id="submitBtn" disabled>
                        <i class="fas fa-stethoscope"></i> Analyze Symptoms
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Get symptoms data from Laravel
        const symptoms = @json($symptoms);
        
        let selectedSymptoms = new Set();
        let currentFilter = '';
        let currentLetter = '';

        function initializeAlphabetFilter() {
            const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
            const filterContainer = document.getElementById('alphabetFilter');
            
            alphabet.forEach(letter => {
                const btn = document.createElement('button');
                btn.className = 'letter-btn';
                btn.textContent = letter;
                btn.onclick = () => filterByLetter(letter);
                filterContainer.appendChild(btn);
            });
        }

        function renderSymptoms() {
            const grid = document.getElementById('symptomsGrid');
            const noSymptoms = document.getElementById('noSymptoms');
            
            let filteredSymptoms = symptoms.filter(symptom => {
                const matchesSearch = symptom.display_name.toLowerCase().includes(currentFilter.toLowerCase());
                const matchesLetter = !currentLetter || symptom.display_name.charAt(0).toLowerCase() === currentLetter.toLowerCase();
                return matchesSearch && matchesLetter;
            });

            // Sort alphabetically
            filteredSymptoms.sort((a, b) => a.display_name.localeCompare(b.display_name));

            if (filteredSymptoms.length === 0) {
                grid.style.display = 'none';
                noSymptoms.style.display = 'block';
                return;
            }

            grid.style.display = 'grid';
            noSymptoms.style.display = 'none';

            grid.innerHTML = filteredSymptoms.map(symptom => `
                <div class="symptom-card ${selectedSymptoms.has(symptom.symptom_key) ? 'selected' : ''}" 
                     onclick="toggleSymptom('${symptom.symptom_key}', this)">
                    <input type="checkbox" class="symptom-checkbox" 
                           name="symptoms[]" 
                           value="${symptom.symptom_key}" 
                           ${selectedSymptoms.has(symptom.symptom_key) ? 'checked' : ''}>
                    <div class="symptom-text">
                        <div class="symptom-icon">
                            <i class="fas fa-check" style="font-size: 12px;"></i>
                        </div>
                        ${symptom.display_name}
                    </div>
                </div>
            `).join('');
        }

        function toggleSymptom(symptomKey, cardElement) {
            const checkbox = cardElement.querySelector('input[type="checkbox"]');
            
            if (selectedSymptoms.has(symptomKey)) {
                selectedSymptoms.delete(symptomKey);
                cardElement.classList.remove('selected');
                checkbox.checked = false;
            } else {
                selectedSymptoms.add(symptomKey);
                cardElement.classList.add('selected');
                checkbox.checked = true;
            }
            
            updateSelectedCount();
            updateSubmitButton();
        }

        function updateSelectedCount() {
            const count = selectedSymptoms.size;
            const countElement = document.getElementById('selectedCount');
            const icon = count > 0 ? 'fa-check-circle' : 'fa-circle';
            countElement.innerHTML = `<i class="fas ${icon}"></i> ${count} symptom${count !== 1 ? 's' : ''} selected`;
        }

        function updateSubmitButton() {
            const submitBtn = document.getElementById('submitBtn');
            const hasSelections = selectedSymptoms.size > 0;
            
            submitBtn.disabled = !hasSelections;
            submitBtn.innerHTML = hasSelections 
                ? '<i class="fas fa-stethoscope"></i> Analyze Symptoms'
                : '<i class="fas fa-exclamation-triangle"></i> Select symptoms first';
        }

        function filterByLetter(letter) {
            // Toggle letter filter
            if (currentLetter === letter) {
                currentLetter = '';
                document.querySelectorAll('.letter-btn').forEach(btn => btn.classList.remove('active'));
            } else {
                currentLetter = letter;
                document.querySelectorAll('.letter-btn').forEach(btn => btn.classList.remove('active'));
                event.target.classList.add('active');
            }
            
            renderSymptoms();
        }

        function clearAllFilters() {
            currentFilter = '';
            currentLetter = '';
            document.getElementById('searchInput').value = '';
            document.querySelectorAll('.letter-btn').forEach(btn => btn.classList.remove('active'));
            renderSymptoms();
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            currentFilter = e.target.value;
            renderSymptoms();
        });

        // Form submission
        document.getElementById('symptomForm').addEventListener('submit', function(e) {
            if (selectedSymptoms.size === 0) {
                e.preventDefault();
                alert('Please select at least one symptom before submitting.');
            }
        });

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            initializeAlphabetFilter();
            renderSymptoms();
            updateSelectedCount();
        });
    </script>
</body>
</html>
</x-app-layout>