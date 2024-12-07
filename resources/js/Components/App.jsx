import React from "react";
import { createRoot } from 'react-dom/client';
export default function App(){
    return(
        <div className="container text-center">
            <h1>How to Install and Configure React 18 Application in Laravel 10 with Vite 3 - LaravelClick</h1>
            <blockquote className="text-center h5">
                Hi friends, in this tutorial you have learnt how to install and configure a simple React 18 application in Laravel 10 with Vite 3.<br />
                To learn more, please visit <strong>Recommended <a href="https://www.laravelclick.com/category/laravel">Laravel Tutorials</a></strong> and improvise yourself.
            </blockquote>
        </div>
    );
};
const container = document.getElementById('root');
const root = createRoot(container);
root.render(<App />);
