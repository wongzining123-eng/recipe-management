import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import Navbar from './components/Navbar';
import Dashboard from './components/Dashboard';
import Users from './components/Users';
import Profile from './components/Profile';

function AdminApp() {
    const [page, setPage] = useState(() => {
        const path = window.location.pathname;
        if (path.includes('/admin/profile')) return 'profile';
        if (path.includes('/admin/users')) return 'users';
        return 'dashboard';
    });

    const navigate = (newPage) => {
        const urls = {
            dashboard: '/admin/dashboard',
            users: '/admin/users',
            profile: '/admin/profile',
            
            // User Blade pages
            'user-home': '/home',
            'user-recipes': '/recipes',
            'user-create-recipe': '/recipes/create',
            'user-my-recipes': '/my-recipes',
        };
        
        if (newPage === 'dashboard' || newPage === 'users' || newPage === 'profile') {
            window.history.pushState({}, '', urls[newPage]);
            setPage(newPage);
        } else {
            window.location.href = urls[newPage];
        }
    };

    useEffect(() => {
        const handlePopState = () => {
            const path = window.location.pathname;
            if (path.includes('/admin/profile')) setPage('profile');
            else if (path.includes('/admin/users')) setPage('users');
            else if (path.includes('/admin/dashboard')) setPage('dashboard');
            else {
                window.location.reload();
            }
        };
        
        window.addEventListener('popstate', handlePopState);
        return () => window.removeEventListener('popstate', handlePopState);
    }, []);

    return (
        <div>
            <Navbar navigate={navigate} currentPage={page} />
            {page === 'dashboard' && <Dashboard />}
            {page === 'recipes-manage' && <Recipes />}
            {page === 'users' && <Users />}
            {page === 'categories' && <Categories />}
            {page === 'profile' && <Profile />}
        </div>
    );
}

const el = document.getElementById('admin-app');
if (el) {
    ReactDOM.render(<AdminApp />, el);
}