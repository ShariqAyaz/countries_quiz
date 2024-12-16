// File: resources/js/pages/HomePage.jsx
import React, { useEffect, useState } from 'react';
import { privateClient, publicClient } from '@/api/axiosConfig';
import initializeCsrf from '@/api/initializeCsrf';
import Home from '@/components/Home';

const HomePage = () => {
    const [currentQuiz, setCurrentQuiz] = useState(null);
    const [loading, setLoading] = useState(true);
    const [feedback, setFeedback] = useState(null);
    const [error, setError] = useState(null);
    const [submitting, setSubmitting] = useState(false);

    // A function to initialize and fetch a new question
    const fetchNewQuestion = async () => {
        try {
            setLoading(true);
            setError(null);
            setFeedback(null);

            // Re-initialize CSRF and auto-login to ensure session
            await initializeCsrf();
            await publicClient.get('/auto-login');

            // Fetch a new quiz question
            const response = await privateClient.get('/new-question');
            setCurrentQuiz(response.data);
        } catch (err) {
            console.error('Error fetching new question:', err);
            setError('Failed to load the quiz. Please try again.');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        // Initial setup on component mount
        (async () => {
            await fetchNewQuestion();
        })();
    }, []);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setFeedback(null);
        setError(null);
        setSubmitting(true);

        const formData = new FormData(e.target);
        const data = {
            country: formData.get('country'),
            capital: formData.get('capital'),
        };

        try {
            const response = await privateClient.post('/post-answer', data);
            if (response.data.message === 'correct') {
                setFeedback('Correct! Well done.');
            } else if (response.data.message === 'not correct') {
                setFeedback(`Not correct. The correct capital is ${response.data.correct_capital}.`);
            }
        } catch (err) {
            console.error('Error submitting answer:', err);
            if (err.response && err.response.status === 401) {
                setError('Session expired. Please refresh the page.');
            } else {
                setError('An error occurred while submitting your answer.');
            }
        } finally {
            setSubmitting(false);
        }
    };

    if (loading) {
        return <div>Loading...</div>;
    }

    return (
        <Home>
            <div className="mb-4 display-4">
                <i>Guess the</i> <span className="display-1">Capital</span>
            </div>

            {error && <div className="alert alert-danger">{error}</div>}
            {feedback && <div className="alert alert-info">{feedback}</div>}

            {/* When feedback is present, show a "New Question" button */}
            {feedback && (
                <div className="mt-3">
                    <button
                        className="btn btn-warning"
                        onClick={fetchNewQuestion}
                    >
                        New Question
                    </button>
                </div>
            )}

            {!feedback && (
                <form onSubmit={handleSubmit}>
                    <div className="mb-3">
                        <p>
                            <strong>
                                What is the capital of{' '}
                                {currentQuiz?.data?.country || '...loading'}?
                            </strong>
                        </p>
                        <input
                            type="hidden"
                            name="country"
                            value={currentQuiz?.data?.country || ''}
                        />
                        {currentQuiz?.data?.capitals?.map((capital, index) => (
                            <div className="form-check mb-3" key={index}>
                                <input
                                    className="form-check-input"
                                    type="radio"
                                    name="capital"
                                    id={`capital${index}`}
                                    value={capital}
                                    required
                                />
                                <label
                                    className="form-check-label"
                                    htmlFor={`capital${index}`}
                                >
                                    {capital}
                                </label>
                            </div>
                        ))}
                    </div>
                    <button
                        type="submit"
                        className="btn btn-success"
                        disabled={submitting}
                    >
                        {submitting ? 'Submitting...' : 'Check Answer'}
                    </button>
                </form>
            )}
        </Home>
    );
};

export default HomePage;
