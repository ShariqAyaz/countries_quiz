// File: resources/js/components/Home.jsx
import React from 'react';

const Home = ({ children }) => {
    return (
        <div className="d-flex flex-column min-vh-100">
            <main className="container mt-5">{children}</main>
            <footer className="bg-info py-3 text-white text-center mt-auto">
                <p className="mb-0">Countries Quiz</p>
            </footer>
        </div>
    );
};

export default Home;
