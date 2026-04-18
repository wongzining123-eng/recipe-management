import React, { useState, useEffect } from 'react';
import axios from 'axios';

function Users() {
    const [users, setUsers] = useState([]);
    const [message, setMessage] = useState(null);
    const [error, setError] = useState(null);
    const [loading, setLoading] = useState(true);

    const fetchUsers = () => {
        setLoading(true);
        setError(null);

        axios.get('/admin/api/users', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Accept': 'application/json',
            },
            withCredentials: true
        })
        .then(res => {
            setUsers(res.data.data || []);
            setLoading(false);
        })
        .catch(err => {
            console.error('Fetch error:', err);
            setError('Failed to load users. Please refresh the page.');
            setLoading(false);
        });
    };

    useEffect(() => {
        fetchUsers();
    }, []);

    const toggleRole = (id, name) => {
        if (!confirm(`Change ${name}'s role?`)) return;

        axios.patch(`/admin/api/users/${id}/toggle-role`, {}, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Accept': 'application/json',
            },
            withCredentials: true
        })
        .then(res => {
            const data = res.data;

            if (data.error) {
                setError(data.error);
                setTimeout(() => setError(null), 5000);
            } else {
                setMessage(data.message);
                fetchUsers();
                setTimeout(() => setMessage(null), 3000);
            }
        })
        .catch(err => {
            console.error('Toggle role error:', err);
            setError('Something wrong happened. Please try again.');
            setTimeout(() => setError(null), 5000);
        });
    };

    const goToDashboard = () => {
        window.location.href = '/admin/dashboard';
    };

    if (error) {
        return (
            <div className="container mt-4">
                <div className="alert alert-danger">
                    <h4>Error</h4>
                    <p>{error}</p>
                    <div className="d-flex gap-2 mt-3">
                        <button className="btn btn-secondary" onClick={goToDashboard}>
                            ← Back to Dashboard
                        </button>
                        <button
                            className="btn btn-primary"
                            onClick={() => {
                                setError(null);
                                window.location.reload();
                            }}
                        >
                            Retry
                        </button>
                    </div>
                </div>
            </div>
        );
    }

    if (loading) {
        return (
            <div className="container mt-4">
                <div className="text-center">
                    <div className="spinner-border text-primary" role="status">
                        <span className="visually-hidden">Loading...</span>
                    </div>
                    <p>Loading users...</p>
                </div>
            </div>
        );
    }

    return (
        <div className="container mt-4">
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h1 className="mb-0">Manage Users</h1>
                <button className="btn btn-secondary" onClick={goToDashboard}>
                    ← Back to Dashboard
                </button>
            </div>

            {message && (
                <div className="alert alert-success alert-dismissible fade show">
                    {message}
                    <button type="button" className="btn-close" onClick={() => setMessage(null)}></button>
                </div>
            )}

            <div className="card">
                <div className="card-body table-responsive">
                    <table className="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Recipes</th>
                                <th>Joined</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            {users.length === 0 ? (
                                <tr>
                                    <td colSpan="7" className="text-center">
                                        No users found
                                    </td>
                                </tr>
                            ) : (
                                users.map(u => (
                                    <tr key={u.id}>
                                        <td>{u.id}</td>
                                        <td>{u.name}</td>
                                        <td>{u.email}</td>
                                        <td>
                                            <span className={`badge ${u.is_admin ? 'bg-danger' : 'bg-secondary'}`}>
                                                {u.is_admin ? 'Admin' : 'User'}
                                            </span>
                                        </td>
                                        <td>{u.recipes_count || 0}</td>
                                        <td>{u.created_at?.slice(0, 10)}</td>
                                        <td>
                                            <button
                                                className={`btn btn-sm ${u.is_admin ? 'btn-warning' : 'btn-success'}`}
                                                onClick={() => toggleRole(u.id, u.name)}
                                            >
                                                {u.is_admin ? 'Remove Admin' : 'Make Admin'}
                                            </button>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    );
}

export default Users;