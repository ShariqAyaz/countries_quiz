// resources/js/pages/HomePage.jsx
import React, { useEffect, useState } from 'react';
import { privateClient } from '@/api/axiosConfig';
import initializeCsrf from '@/api/initializeCsrf';

import Home from '@/components/Home';

const HomePage = () => {
    const [currentQuize, setCurrentQuize] = useState(null);
    const [loading, setLoading] = useState(true);
    const [feedback, setFeedback] = useState(null);
    const [error, setError] = useState(null);

    useEffect(() => {
        initializeCsrf();
    }, []);

    useEffect(() => {
        const fetchCurrentQuize = async () => {
            try {
                const response = await privateClient.get('/new-question');
                setCurrentQuize(response.data);
            } catch (error) {
                console.error('Error fetching data:', error);
                setError('Failed to load the quiz. Please try again.');
            } finally {
                setLoading(false);
            }
        };

        fetchCurrentQuize();
    }, []);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setFeedback(null);
        setError(null);

        const formData = new FormData(e.target);
        const data = {
            country: formData.get('country'),
            capital: formData.get('capital'),
        };

        try {
            const response = await privateClient.post('/post-answer', data);
            setFeedback(response.data.message);

            if (response.data.message === 'not correct') {
                setFeedback(`Not correct. The correct capital is ${response.data.correct_capital}.`);
            } else if (response.data.message === 'correct') {
                setFeedback('Correct! Well done.');
            }
        } catch (err) {
            console.error('Error submitting answer:', err);
            if (err.response && err.response.status === 401) {
                setError('Session expired. Please log in again.');
            } else {
                setError('An error occurred while submitting your answer.');
            }
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
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <p>
                        <strong>
                            What is the capital of{' '}
                            {currentQuize?.data?.country || '...loading'}?
                        </strong>
                    </p>
                    <input
                        type="hidden"
                        name="country"
                        value={currentQuize?.data?.country || ''}
                    />
                    {currentQuize?.data?.capitals?.map((capital, index) => (
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
                <button type="submit" className="btn btn-success">
                    Check Answer
                </button>
            </form>
        </Home>
    );
};

export default HomePage;
