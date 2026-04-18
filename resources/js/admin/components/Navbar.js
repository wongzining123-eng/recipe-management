import React from 'react';

const handleLogout = () => {
    fetch('/logout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
        },
        credentials: 'include'
    }).then(() => {
        window.location.href = '/login';
    });
};

function Navbar({ navigate, currentPage }) {
    const navigateToUserPage = (url) => {
        window.location.href = url;
    };

    return (
        <nav className="navbar navbar-dark bg-dark px-4">
            <span className="navbar-brand">⚙️ Admin Panel</span>
            <div className="d-flex gap-2 flex-wrap">
                {/* Admin Section */}
                <div className="dropdown">
                    <button className="btn btn-sm btn-outline-danger dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        ⚙️ Admin
                    </button>
                    <ul className="dropdown-menu">
                        <li>
                            <button 
                                className={`dropdown-item ${currentPage === 'dashboard' ? 'active' : ''}`}
                                onClick={() => navigate('dashboard')}>
                                📊 Admin Dashboard
                            </button>
                        </li>
                        <li>
                            <button 
                                className={`dropdown-item ${currentPage === 'users' ? 'active' : ''}`}
                                onClick={() => navigate('users')}>
                                👥 Manage Users
                            </button>
                        </li>
                        <li>
                            <button 
                                className={`dropdown-item ${currentPage === 'profile' ? 'active' : ''}`}
                                onClick={() => navigate('profile')}>
                                👤 Admin Profile
                            </button>
                        </li>
                    </ul>
                </div>

                {/* User Section (Blade) - Same tab navigation */}
                <div className="dropdown">
                    <button className="btn btn-sm btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        👤 Recipe Management
                    </button>
                    <ul className="dropdown-menu">
                        <li>
                            <button 
                                className="dropdown-item"
                                onClick={() => navigateToUserPage('/recipes')}>
                                📖 All Recipes
                            </button>
                        </li>
                        <li>
                            <button 
                                className="dropdown-item"
                                onClick={() => navigateToUserPage('/categories')}>
                                🏷️ Manage Categories
                            </button>
                        </li>
                    </ul>
                </div>

                <button 
                    className="btn btn-sm btn-outline-danger" 
                    onClick={handleLogout}>
                    🚪 Logout
                </button>
            </div>
        </nav>
    );
}

export default Navbar;