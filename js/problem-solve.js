/**
 * Problem Solve Page JavaScript
 */

// Load problem details on page load
document.addEventListener('DOMContentLoaded', async () => {
    await loadProblemDetails();
});

/**
 * Load problem details
 */
async function loadProblemDetails() {
    const problem = await Problems.get(problemId);
    
    if (problem) {
        renderProblemDetails(problem);
        
        // Set code template
        const editor = document.getElementById('codeEditor');
        if (problem.solution_template) {
            editor.value = problem.solution_template;
        }
    } else {
        document.getElementById('problemContent').innerHTML = 
            '<div class="alert alert-danger">Problem not found</div>';
    }
}

/**
 * Render problem details
 */
function renderProblemDetails(problem) {
    const content = document.getElementById('problemContent');
    
    let html = `
        <div class="problem-description">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>${App.escapeHtml(problem.title)}</h3>
                ${App.getDifficultyBadge(problem.difficulty)}
            </div>
            
            <div class="mb-3">
                <span class="badge bg-secondary">${App.escapeHtml(problem.category || 'General')}</span>
            </div>
            
            <div class="mb-4">
                <h5>Description</h5>
                <p>${App.escapeHtml(problem.description)}</p>
            </div>
    `;
    
    // Parse and display test cases if available
    if (problem.test_cases) {
        try {
            const testCases = JSON.parse(problem.test_cases);
            
            html += `
                <div class="mb-3">
                    <h5>Example Test Cases</h5>
            `;
            
            if (Array.isArray(testCases)) {
                testCases.forEach((testCase, index) => {
                    if (typeof testCase === 'object' && testCase.input && testCase.output) {
                        html += `
                            <div class="test-case">
                                <strong>Test Case ${index + 1}:</strong><br>
                                <code>Input: ${JSON.stringify(testCase.input)}</code><br>
                                <code>Output: ${JSON.stringify(testCase.output)}</code>
                            </div>
                        `;
                    }
                });
            }
            
            html += `</div>`;
        } catch (e) {
            console.error('Failed to parse test cases:', e);
        }
    }
    
    html += `
            <div class="text-muted">
                <small>
                    <i class="fas fa-clock me-1"></i>Created: ${App.formatDate(problem.created_at)}
                </small>
            </div>
        </div>
    `;
    
    content.innerHTML = html;
}

/**
 * Run code (client-side simulation)
 */
function runCode() {
    const code = document.getElementById('codeEditor').value;
    const language = document.getElementById('languageSelect').value;
    const output = document.getElementById('outputPanel');
    
    if (!code.trim()) {
        output.innerHTML = '<div class="alert alert-warning mb-0">Please write some code first</div>';
        return;
    }
    
    // Show running status
    output.innerHTML = `
        <div class="d-flex align-items-center">
            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
            <span>Running code...</span>
        </div>
    `;
    
    // Simulate code execution (In production, this would call a backend API)
    setTimeout(() => {
        output.innerHTML = `
            <div class="alert alert-info mb-0">
                <h6>Test Run Complete</h6>
                <p class="mb-0">Note: This is a simulation. In production, code would be executed on a secure server.</p>
                <hr>
                <strong>Language:</strong> ${language}<br>
                <strong>Status:</strong> <span class="text-success">Ready to submit</span>
            </div>
        `;
    }, 1500);
}

/**
 * Submit code
 */
async function submitCode() {
    const code = document.getElementById('codeEditor').value;
    const language = document.getElementById('languageSelect').value;
    
    if (!code.trim()) {
        App.showAlert('Please write some code first', 'warning');
        return;
    }
    
    const resultsModal = new bootstrap.Modal(document.getElementById('resultsModal'));
    const resultsContent = document.getElementById('resultsContent');
    
    resultsContent.innerHTML = `
        <div class="text-center my-4">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2">Evaluating your submission...</p>
        </div>
    `;
    
    resultsModal.show();
    
    try {
        const formData = new FormData();
        formData.append('problem_id', problemId);
        formData.append('code', code);
        formData.append('language', language);
        
        const response = await fetch('/api/submissions.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            const submission = data.data;
            const isAccepted = submission.status === 'accepted';
            
            resultsContent.innerHTML = `
                <div class="alert ${isAccepted ? 'alert-success' : 'alert-danger'}">
                    <h4>
                        <i class="fas ${isAccepted ? 'fa-check-circle' : 'fa-times-circle'} me-2"></i>
                        ${getStatusText(submission.status)}
                    </h4>
                </div>
                
                <div class="mb-3">
                    <strong>Submission ID:</strong> #${submission.submission_id}<br>
                    <strong>Status:</strong> ${getStatusText(submission.status)}<br>
                    <strong>Language:</strong> ${language}<br>
                    <strong>Execution Time:</strong> ${submission.execution_time}ms<br>
                    <strong>Memory Used:</strong> ${submission.memory_used}MB
                </div>
                
                ${isAccepted ? `
                    <div class="alert alert-info">
                        <strong>Great job!</strong> Your solution passed all test cases.
                    </div>
                ` : `
                    <div class="alert alert-warning">
                        <strong>Test Failed:</strong> Your solution ${getStatusMessage(submission.status)}.
                    </div>
                `}
            `;
            
            if (isAccepted) {
                App.showAlert('Congratulations! Your solution was accepted!', 'success');
            }
        } else {
            resultsContent.innerHTML = `
                <div class="alert alert-danger">
                    <h4>Submission Failed</h4>
                    <p>${data.message}</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Submission error:', error);
        resultsContent.innerHTML = `
            <div class="alert alert-danger">
                <h4>Error</h4>
                <p>Failed to submit your solution. Please try again.</p>
            </div>
        `;
    }
}

/**
 * Get status text
 */
function getStatusText(status) {
    const statusMap = {
        'accepted': 'Accepted',
        'wrong_answer': 'Wrong Answer',
        'error': 'Runtime Error',
        'timeout': 'Time Limit Exceeded',
        'pending': 'Pending'
    };
    return statusMap[status] || status;
}

/**
 * Get status message
 */
function getStatusMessage(status) {
    const messageMap = {
        'wrong_answer': 'failed on some test cases',
        'error': 'encountered a runtime error',
        'timeout': 'exceeded the time limit',
        'pending': 'is being evaluated'
    };
    return messageMap[status] || 'did not pass';
}

/**
 * Reset code to template
 */
function resetCode() {
    if (confirm('Are you sure you want to reset your code?')) {
        loadProblemDetails();
    }
}
